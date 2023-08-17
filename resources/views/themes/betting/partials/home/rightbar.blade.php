<!-- rightbar -->
<div class="rightbar" id="rightbar">
    <div class="my-1 d-lg-none">
        <button
            class="remove-class-btn light btn-custom"
            onclick="removeClass('rightbar')"
        >
            <i class="fal fa-chevron-left"></i> @lang('Back')
        </button>
    </div>
    <div class="top mb-3 d-flex">
        <button class="btn-custom me-1">
            <i class="fas fa-podcast"></i>
            @lang('bet slip')
        </button>
        <a href="{{route('user.betHistory')}}" class="btn-custom2 light">
            <i class="fas fa-meteor"></i>
            @lang('my bets')
        </a>
    </div>

    <div  :class="{ 'd-none': 0 == betSlip.length }">
        <div class="mb-2">
            <div class="d-flex justify-content-between">
                <p class="mb-0">@lang('Your Bets') @{{ betSlip.length }}</p>

            </div>
        </div>

        <template>
        <div class="bet-box-wrapper">
            <div  v-for="(item, index) in betSlip" class="bet-box mb-2" :class="{'bet-box-disable':(item.is_unlock_match == 1 || item.is_unlock_question == 1)}">
                <p class="series d-flex align-items-start">
                  <span>
                    <span v-html="item.category_icon"></span> @{{ item.tournament_name }}
                  </span>
                    <button type="button" @click="removeItem(item)" class="close-btn">
                        <i class="fal fa-times"></i>
                    </button>
                </p>

                <p class="teams">@{{item.match_name}} </p>
                <p>
                    <span class="badge">@{{ item.ratio }}</span>
                    <span>@{{item.question_name}}
                 <small>@{{item.option_name}}</small>
                </span>
                </p>

                <p v-if="item.is_unlock_match == 1 || item.is_unlock_question == 1" class="text-center "><i class="fas fa-hourglass-end"></i>@lang('Expired')</p>
            </div>
        </div>
        </template>

        <div class="mb-3">
            <p class="mb-1">
                @lang('Overall Odds') <span class="float-end">@{{ totalOdds }}</span>
            </p>
            <p class="mb-1">
                @lang('Maximum stake amount') <span class="float-end">@{{ minimum_bet }} @{{ currency }}</span>
            </p>
            <p class="mb-1">
                @lang('Charge Apply') <small> (IF YOU WIN) </small><span class="float-end">@{{win_charge}}%</span>
            </p>

            <p class="mb-1">
                @lang('Potential Winnings') <span class="float-end">@{{ return_amount }} @{{ currency }}</span>
            </p>
        </div>

        <div class="input-group inc-dec mb-3">
            <button type="button" class="decrement btn-custom" @click="decrement()">-</button>
            <input  class="form-control" value="1"  v-model="form.amount"
                   @keyup="calc(form.amount)"
                   type="number"
                   data-zeros="true"
                   :max="999999"/>
            <button type="button" class="increment btn-custom" @click="increment()">+</button>
        </div>
        <button type="button" @click="betPlace" class=" btn-custom w-100">@lang('place bet')</button>
    </div>
</div>
