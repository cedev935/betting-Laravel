<?php $__env->startSection('title',trans('Dashboard')); ?>
<?php $__env->startSection('content'); ?>
    <!-- contents -->
    <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-3 col-sm-10 mb-2">
            <div class="dashboard__card">
                <div class="dashboard__card-content">
                    <h2 class="price"><sup><?php echo e(config('basic.currency_symbol')); ?></sup><?php echo e(Auth()->user()->balance); ?></h2>
                    <p class="info"><?php echo app('translator')->get('Total Balance'); ?></p>
                </div>
                <div class="dashboard__card-icon">
                    <img src="<?php echo e(asset('assets/themes/betting/images/icon/wallet.png')); ?>" alt="...">
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-md-3 col-sm-10 mb-2">
            <div class="dashboard__card">
                <div class="dashboard__card-content">
                    <h2 class="price"><sup><?php echo e(config('basic.currency_symbol')); ?></sup><?php echo e($userBet['totalInvest']); ?></h2>
                    <p class="info"><?php echo app('translator')->get('Total Bet Amount'); ?></p>
                </div>
                <div class="dashboard__card-icon">
                    <img src="<?php echo e(asset('assets/themes/betting/images/icon/invest.png')); ?>" alt="...">
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-md-3 col-sm-10 mb-2">
            <div class="dashboard__card">
                <div class="dashboard__card-content">
                    <h2 class="price"><?php echo e($userBet['totalBet']); ?></h2>
                    <p class="info"><?php echo app('translator')->get('Total Bet'); ?></p>
                </div>
                <div class="dashboard__card-icon">
                    <img src="<?php echo e(asset('assets/themes/betting/images/icon/bet.png')); ?>" alt="...">
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-md-3 col-sm-10 mb-2">
            <div class="dashboard__card">
                <div class="dashboard__card-content">
                    <h2 class="price"><?php echo e($userBet['win']); ?></h2>
                    <p class="info"><?php echo app('translator')->get('Bet Win'); ?></p>
                </div>
                <div class="dashboard__card-icon">
                    <img src="<?php echo e(asset('assets/themes/betting/images/icon/earn.png')); ?>" alt="...">
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-6 col-sm-12">
            <div id="container" class="apexcharts-canvas"></div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body ">
                    <div class="table-parent table-responsive m-0">
                        <table class="table  table-striped" id="service-table">
                            <thead>
                            <tr>
                                <th><?php echo app('translator')->get('SL No.'); ?></th>
                                <th><?php echo app('translator')->get('Invest Amount'); ?></th>
                                <th><?php echo app('translator')->get('Return Amount'); ?></th>
                                <th><?php echo app('translator')->get('Charge'); ?></th>
                                <th><?php echo app('translator')->get('Ratio'); ?></th>
                                <th class="text-center"><?php echo app('translator')->get('Status'); ?></th>
                                <th class="text-center"><?php echo app('translator')->get('Information'); ?></th>
                                <th><?php echo app('translator')->get('Time'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $betInvests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td data-label="<?php echo app('translator')->get('SL No.'); ?>"><?php echo e(++$key); ?></td>
                                    <td data-label="<?php echo app('translator')->get('Invest Amount'); ?>"><?php echo e(config('basic.currency_symbol')); ?><?php echo app('translator')->get($item->invest_amount); ?></td>
                                    <td data-label="<?php echo app('translator')->get('Return Amount'); ?>"><?php echo e(config('basic.currency_symbol')); ?><?php echo app('translator')->get($item->return_amount); ?></td>
                                    <td data-label="<?php echo app('translator')->get('Charge'); ?>"><?php echo e(config('basic.currency_symbol')); ?><?php echo app('translator')->get($item->charge); ?></td>
                                    <td data-label="<?php echo app('translator')->get('Ratio'); ?>"> <?php echo app('translator')->get($item->ratio); ?></td>
                                    <td data-label="<?php echo app('translator')->get('Status'); ?>" class="text-center">
                                        <?php if($item->status == 0): ?>
                                            <span class="badge bg-warning"><?php echo app('translator')->get('Processing'); ?></span>
                                        <?php elseif($item->status == 1): ?>
                                            <span class="badge bg-success"><?php echo app('translator')->get('Win'); ?></span>
                                        <?php elseif($item->status == -1): ?>
                                            <span class="badge bg-danger"><?php echo app('translator')->get('Loss'); ?></span>
                                        <?php elseif($item->status == 2): ?>
                                            <span class="badge bg-primary"><?php echo app('translator')->get('Refund'); ?></span>
                                        <?php endif; ?>

                                    </td>
                                    <td data-label="<?php echo app('translator')->get('Information'); ?>" class="text-center">
                                        <button type="button" data-resource="<?php echo e($item->betInvestLog); ?>"
                                                data-bs-target="#investLogList" data-bs-toggle="modal"
                                                class="action-btn investLogList">
                                            <i class="fa fa-info-circle"></i></button>
                                    </td>
                                    <td data-label="<?php echo app('translator')->get('Time'); ?>">
                                        <?php echo e(dateTime($item->created_at, 'd M Y h:i A')); ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr class="text-center">
                                    <td colspan="100%"><?php echo e(__('No Data Found!')); ?></td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="investLogList" role="dialog">
        <div class="modal-dialog  modal-xl">
            <div class="modal-custom-content">
                <div class="modal-header modal-colored-header">
                    <h5 class="modal-title service-title"><?php echo app('translator')->get('Information'); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped" id="service-table">
                        <thead class="thead-dark">
                        <tr>
                            <th><?php echo app('translator')->get('#'); ?></th>
                            <th><?php echo app('translator')->get('Match Name'); ?></th>
                            <th><?php echo app('translator')->get('Category Name'); ?></th>
                            <th><?php echo app('translator')->get('Tournament Name'); ?></th>
                            <th><?php echo app('translator')->get('Question Name'); ?></th>
                            <th><?php echo app('translator')->get('Option Name'); ?></th>
                            <th><?php echo app('translator')->get('Ratio'); ?></th>
                            <th><?php echo app('translator')->get('Result'); ?></th>
                        </tr>
                        </thead>
                        <tbody class="result-body">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-custom me-2 mb-2"
                            data-bs-dismiss="modal"><span><?php echo app('translator')->get('Close'); ?></span></button>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset($themeTrue.'js/apexcharts.js')); ?>"></script>
    <script>
        'use strict'
        $(document).on('click', '.investLogList', function () {
            var obj = $(this).data('resource');
            var output = [];
            if (0 < obj.length) {
                obj.map(function (obj, i) {
                    var tr =
                        `<tr>
                        <td data-label="<?php echo app('translator')->get('#'); ?>">${++i}</td>
                        <td data-label="<?php echo app('translator')->get('Match Name'); ?>">${(obj).match_name}</td>
                        <td data-label="<?php echo app('translator')->get('Category Name'); ?>">${obj.category_icon} ${obj.category_name}</td>
                        <td data-label="<?php echo app('translator')->get('Tournament Name'); ?>">${obj.tournament_name}</td>
                        <td data-label="<?php echo app('translator')->get('Question Name'); ?>">${obj.question_name}</td>
                        <td data-label="<?php echo app('translator')->get('Option Name'); ?>">${obj.option_name}</td>
                        <td data-label="<?php echo app('translator')->get('Ratio'); ?>">${obj.ratio}</td>
                        <td data-label="<?php echo app('translator')->get('Result'); ?>">
                            ${(obj.status == '0') ? ` <span class='badge bg-warning'><?php echo app('translator')->get('Processing'); ?></span>` : ''}
                            ${(obj.status == '2') ? ` <span class='badge bg-success'><?php echo app('translator')->get('Win'); ?></span>` : ''}
                            ${(obj.status == '-2') ? ` <span class='badge bg-danger'><?php echo app('translator')->get('Lose'); ?></span>` : ''}
                            ${(obj.status == '3') ? ` <span class='badge bg-secondary'><?php echo app('translator')->get('Refunded'); ?></span>` : ''}

                        </td>
                    </tr>`;

                    output[i] = tr;
                });

            } else {
                output[0] = `
                        <tr>
                            <td colspan="100%" class=""text-center><?php echo app('translator')->get('No Data Found'); ?></td>
                        </tr>`;
            }

            $('.result-body').html(output);
        });

        var options = {
            theme: {
                mode: '<?php echo e((session()->get('dark-mode') == 'true') ? 'dark' :  ''); ?>',
            },
            series: [
                {
                    name: "<?php echo e(trans('Invested')); ?>",
                    color: '<?php echo e(config('basic.base_color')); ?>',
                    data: <?php echo $dailyPayout->flatten(); ?>

                },

            ],
            chart: {
                type: 'bar',
                // height: ini,
                background: '<?php echo e((session()->get('dark-mode') == 'true') ? '#294056' :  '#ffffff'); ?> ',
                toolbar: {
                    show: false
                }

            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: <?php echo $dailyPayout->keys(); ?>,

            },
            yaxis: {
                title: {
                    text: ""
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                colors: ['#000'],
                y: {
                    formatter: function (val) {
                        return val + " <?php echo e(config('basic.currency')); ?>"
                    }
                }
            }
        };
        var chart = new ApexCharts(document.querySelector("#container"), options);
        chart.render();

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\work\betting\orca odd\resources\views/themes/betting/user/dashboard.blade.php ENDPATH**/ ?>