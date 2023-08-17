<?php $__env->startSection('title',trans('Home')); ?>

<?php $__env->startSection('content'); ?>

    <!-- wrapper -->
    <div class="wrapper" id="getMatchList" v-cloak>
        <!-- leftbar -->
        <div class="leftbar" id="leftbar">
            <div class="px-1 mt-2 d-lg-none">
                <button
                    class="remove-class-btn light btn-custom"
                    onclick="removeClass('leftbar')"
                >
                    <i class="fal fa-chevron-left"></i> <?php echo app('translator')->get('Back'); ?>
                </button>
            </div>
            <div class="top p-1 d-flex">
                <button @click="liveUpComing('live')" type="button" :class="{light: (showType == 'upcoming')}"  class="btn-custom me-1">
                    <i class="las la-podcast"></i>
                    <?php echo app('translator')->get('Live'); ?>
                </button>
                <button @click="liveUpComing('upcoming')" type="button" :class="{light: (showType == 'live')}"  class="btn-custom ">
                    <i class="las la-meteor"></i>
                    <?php echo app('translator')->get('Upcoming'); ?>
                </button>
            </div>
            <?php echo $__env->make($theme.'partials.home.leftMenu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <div class="bottom p-1">
                <a href="<?php echo e(route('betResult')); ?>" class="btn-custom light w-100"><?php echo app('translator')->get('results'); ?></a>
            </div>
        </div>

        <?php echo $__env->make($theme.'partials.home.rightbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- contents -->
        <div class="content">
            <?php echo $__env->make($theme.'partials.home.slider', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make($theme.'partials.home.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php if(Request::routeIs('match')): ?>
                <?php echo $__env->make($theme.'partials.home.match', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php else: ?>
                <?php echo $__env->make($theme.'partials.home.content', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>

        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>

    <?php
        $segments = request()->segments();
        $last  = end($segments);

    ?>

    <script>
        let getMatchList = new Vue({
            el: "#getMatchList",
            data: {

                loaded: true,
                currency_symbol: "<?php echo e(config('basic.currency_symbol')); ?>",
                currency: "<?php echo e(config('basic.currency')); ?>",
                minimum_bet: "<?php echo e(config('basic.minimum_bet')); ?>",
                allSports_filter: [],
                upcoming_filter: [],

                selectedData: {},
                betSlip: [],
                totalOdds: 0,
                minimumAmo: 1,
                return_amount: 0,
                win_charge: "<?php echo e(config('basic.win_charge')); ?>",
                form: {
                    amount: ''
                },
                showType: 'live'
            },
            mounted() {
                var showType = localStorage.getItem('showType');
                if (showType == null) {
                    localStorage.setItem("showType", 'live');
                }
                this.showType = localStorage.getItem("showType")

                this.getMatches();
                this.getSlip();
                this.getEvents();


            },
            methods: {
                async getMatches() {
                    var _this = this;
                    var _segment = "<?php echo e(Request::segment(1)); ?>"
                    var routeName = "<?php echo e(Request::route()->getName()); ?>"
                    var $lastSegment = "<?php echo e($last); ?>"

                    var $url = '<?php echo e(route('allSports')); ?>';

                    if (routeName == 'category') {
                        $url = '<?php echo e(route('allSports')); ?>?categoryId=' + $lastSegment;
                    }
                    if (routeName == 'tournament') {
                        $url = '<?php echo e(route('allSports')); ?>?tournamentId=' + $lastSegment;
                    }

                    if (routeName == 'match') {
                        $url = '<?php echo e(route('allSports')); ?>?matchId=' + $lastSegment;
                    }


                    await axios.get($url)
                        .then(function (response) {
                            _this.allSports_filter = response.data.liveList;
                            _this.upcoming_filter = response.data.upcomingList;
                        })
                        .catch(function (error) {
                            console.log(error);
                        })
                },

                addToSlip(data) {
                    if (data.is_unlock_question == 1 || data.is_unlock_match == 1) {
                        return 0;
                    }
                    var _this = this;
                    const index = _this.betSlip.findIndex(object => object.match_id === data.match_id);
                    if (index === -1) {
                        _this.betSlip.push(data);
                        Notiflix.Notify.Success("Added to Bet slip");
                    } else {
                        var result = _this.betSlip.map(function (obj) {
                            if (obj.match_id == data.match_id) {
                                obj = data
                            }
                            return obj
                        });
                        _this.betSlip = result

                        Notiflix.Notify.Info("Bet slip has been updated");
                    }
                    _this.totalOdds = _this.oddsCalc(_this.betSlip)
                    localStorage.setItem("newBetSlip", JSON.stringify(_this.betSlip));
                },
                getSlip() {
                    var _this = this;
                    var selectData = JSON.parse(localStorage.getItem('newBetSlip'));
                    if (selectData != null) {
                        _this.betSlip = selectData;
                    } else {
                        _this.betSlip = []
                    }
                    _this.totalOdds = _this.oddsCalc(_this.betSlip)
                },

                removeItem(obj) {
                    var _this = this;
                    _this.betSlip.splice(_this.betSlip.indexOf(obj), 1);
                    _this.totalOdds = _this.oddsCalc(_this.betSlip)

                    var selectData = JSON.parse(localStorage.getItem('newBetSlip'));
                    var storeIds = selectData.filter(function (item) {
                        if (item.id === obj.id) {
                            return false;
                        }
                        return true;
                    });
                    localStorage.setItem("newBetSlip", JSON.stringify(storeIds));
                },

                oddsCalc(obj) {
                    var ratio = 1;
                    for (var property in obj) {
                        ratio *= parseFloat(obj[property].ratio);
                    }
                    return ratio.toFixed(3);
                },

                decrement() {
                    if (this.form.amount > this.minimumAmo) {
                        this.form.amount--;
                        this.return_amount = parseFloat(this.form.amount * this.totalOdds).toFixed(3);

                        return 0;
                    }
                    return 1;
                },
                increment() {
                    this.form.amount++;
                    this.return_amount = parseFloat(this.form.amount * this.totalOdds).toFixed(3);
                    return 0;
                },
                calc(val) {
                    if (isNaN(val)) {
                        val = 0
                    }
                    if (0 >= val) {
                        val = 0;
                    }
                    this.return_amount = parseFloat(val * this.totalOdds).toFixed(2);
                },

                goMatch(item) {
                    var $url = '<?php echo e(route("match", [":match_name",":match_id"])); ?>';
                    $url = $url.replace(':match_name', item.slug);
                    $url = $url.replace(':match_id', item.id);
                    window.location.href = $url;
                },

                getEvents() {
                    let _this = this;
                    // Pusher.logToConsole = true;
                    let pusher = new Pusher("<?php echo e(env('PUSHER_APP_KEY')); ?>", {
                        encrypted: true,
                        cluster: "<?php echo e(env('PUSHER_APP_CLUSTER')); ?>"
                    });
                    var channel = pusher.subscribe('match-notification');

                    channel.bind('App\\Events\\MatchNotification', function (data) {
                        if (data && data.type == 'Edit') {
                            _this.updateEventData(data)
                        } else if (data && data.type != 'Edit') {
                            _this.enlistedEventData(data)
                        }
                    });

                },
                updateEventData(data) {
                    var _this = this;
                    var list = _this.allSports_filter;
                    const result = list.map(function (obj) {
                        if (obj.id == data.match.id) {
                            obj = data.match
                        }
                        return obj
                    });
                    _this.allSports_filter = result


                    var list2 = _this.upcoming_filter;


                    const upcomingResult = list2.map(function (obj) {
                        if (obj.id == data.match.id) {
                            obj = data.match
                        }
                        return obj
                    });

                    _this.upcoming_filter = upcomingResult
                },
                enlistedEventData(data) {
                    var _this = this;
                    if (data && data.type == 'Enlisted') {
                        var list = _this.allSports_filter;
                        list.push(data.match);
                    }
                    if (data && data.type == 'UpcomingList') {
                        var upcomingList = _this.upcoming_filter;
                        upcomingList.push(data.match);
                    }
                },
                betPlace() {
                    var _this = this;
                    var authCheck = "<?php echo e(auth()->check()); ?>"
                    if (authCheck !== '1') {
                        window.location.href = "<?php echo e(route('login')); ?>"
                        return 0;
                    }
                    if (_this.betSlip.length == 0) {
                        Notiflix.Notify.Failure("Please make a bet slip");
                        return 0
                    }
                    if (_this.form.amount == '') {
                        Notiflix.Notify.Failure("Please put a amount");
                        return 0
                    }
                    if (0 > (_this.form.amount)) {
                        Notiflix.Notify.Failure("Please put a valid amount");
                        return 0
                    }
                    if (parseInt(_this.minimum_bet) > parseInt(_this.form.amount)) {
                        Notiflix.Notify.Failure("Minimum Bet " + _this.minimum_bet + " " + _this.currency);
                        return 0
                    }
                    axios.post('<?php echo e(route('user.betSlip')); ?>', {
                        amount: _this.form.amount,
                        activeSlip: _this.betSlip,
                    })
                        .then(function (response) {
                            if (response.data.errors) {
                                for (err in response.data.errors) {
                                    let error = response.data.errors[err][0]
                                    Notiflix.Notify.Failure("" + error);
                                }
                                return 0;
                            }
                            if (response.data.newSlipMessage) {
                                Notiflix.Notify.Warning("" + response.data.newSlipMessage);
                                var newSlip = response.data.newSlip;
                                var unlisted = _this.getDifference(_this.betSlip, newSlip);
                                const newUnlisted = unlisted.map(function (obj) {
                                    obj.is_unlock_match = 1;
                                    obj.is_unlock_question = 1;
                                    return obj
                                });
                                _this.betSlip.concat(newSlip, newUnlisted);
                                localStorage.setItem("newBetSlip", JSON.stringify(_this.betSlip));
                                return 0;
                            }

                            if (response.data.success) {
                                _this.betSlip = [];
                                localStorage.setItem("newBetSlip", JSON.stringify(_this.betSlip));
                                Notiflix.Notify.Success("Your bet has place successfully");

                                return 0;
                            }

                        })
                        .catch(function (err) {

                        });
                },

                getDifference(array1, array2) {
                    return array1.filter(object1 => {
                        return !array2.some(object2 => {
                            return object1.id === object2.id;
                        });
                    });
                },
                slicedArray(items) {
                    return  Object.values(items)[0];
                },
                liveUpComing(type){
                    localStorage.setItem("showType", type);
                    this.showType = type
                }


            }
        });

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\work\betting\orca odd\resources\views/themes/betting/home.blade.php ENDPATH**/ ?>