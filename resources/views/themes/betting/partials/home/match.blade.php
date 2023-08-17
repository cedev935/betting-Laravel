<div class="all-markets">
    <div class="search-bar">
        <div class="row">
            <div class="col">
                <a href="" class="active">
                    <i class="far fa-table-tennis" aria-hidden="true"></i
                    ><span>@lang('All markets') </span>
                </a>
            </div>

        </div>
    </div>

    <div class="all-markets-questions" >
        <div class="row " v-for="(item, index) in allSports_filter" v-if="showType == 'live'">
            <div class="col-lg-6" :key="question.id"  v-for="(question, index) in item.questions">
                <div class="accordion mb-2"
                     :id="'accordionExample_' + question.id">
                    <div class="accordion-item">
                        <h2 class="accordion-header" :id="'heading_' + question.id">
                            <button
                                class="accordion-button collapsed"
                                type="button"
                                data-bs-toggle="collapse"
                                :data-bs-target="'#collapse_' + question.id"
                                aria-expanded="false"
                                :aria-controls="'collapse_'+ question.id">
                                <a href="">
                                    <i class="fal fa-thumbtack"></i>
                                </a>
                                @{{ question.name }}
                            </button>
                        </h2>
                        <div   :id="'collapse_'+ question.id"
                            class="accordion-collapse collapse show"
                            :aria-labelledby="'heading_'+ question.id"
                            :data-bs-parent="'accordionExample_'+ question.id">
                            <div class="accordion-body">
                                <div class="row gy-1 ">
                                    <div v-for="(option, index) in question.options" class="col-md-6">
                                        <button @click="addToSlip(option)"
                                            :disabled="option.is_unlock_question == 1 || option.is_unlock_match == 1" :class="{ disabled: (option.is_unlock_question == 1 || option.is_unlock_match == 1) }">
                                            <i v-if="option.is_unlock_question == 1 || option.is_unlock_match == 1" class="fas fa-lock-alt mt-1"></i>
                                          <span>
                                             @{{ option.option_name }}
                                          </span>
                                            <span class="float-end">@{{ option.ratio}}</span>
                                        </button>
                                    </div>


                                    <div  v-if="(question.options).length == 0" class="col-md-6">
                                        <button class="disabled downgrade text-center" type="button">-</button>
                                    </div>
                                    <div  v-if="(question.options).length == 0" class="col-md-6">
                                        <button class="disabled downgrade text-center" type="button">-</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row " v-for="(item, index) in upcoming_filter" v-if="showType == 'upcoming'">
            <div class="col-lg-6" :key="question.id"  v-for="(question, index) in item.questions">
                <div class="accordion mb-2"
                     :id="'accordionExample_' + question.id"
                >
                    <div class="accordion-item">
                        <h2 class="accordion-header" :id="'heading_' + question.id">
                            <button
                                class="accordion-button collapsed"
                                type="button"
                                data-bs-toggle="collapse"
                                :data-bs-target="'#collapse_' + question.id"
                                aria-expanded="false"
                                :aria-controls="'collapse_'+ question.id">
                                <a href="">
                                    <i class="fal fa-thumbtack"></i>
                                </a>
                                @{{ question.name }}
                            </button>
                        </h2>
                        <div   :id="'collapse_'+ question.id"
                            class="accordion-collapse collapse show"
                            :aria-labelledby="'heading_'+ question.id"
                            :data-bs-parent="'accordionExample_'+ question.id">
                            <div class="accordion-body">
                                <div class="row gy-1 ">
                                    <div v-for="(option, index) in question.options" class="col-md-6">
                                        <button @click="addToSlip(option)"
                                            :disabled="option.is_unlock_question == 1 || option.is_unlock_match == 1" :class="{ disabled: (option.is_unlock_question == 1 || option.is_unlock_match == 1) }">
                                            <i v-if="option.is_unlock_question == 1 || option.is_unlock_match == 1" class="fas fa-lock-alt mt-1"></i>
                                          <span>
                                             @{{ option.option_name }}
                                          </span>
                                            <span class="float-end">@{{ option.ratio}}</span>
                                        </button>
                                    </div>


                                    <div  v-if="(question.options).length == 0" class="col-md-6">
                                        <button class="disabled downgrade text-center" type="button">-</button>
                                    </div>
                                    <div  v-if="(question.options).length == 0" class="col-md-6">
                                        <button class="disabled downgrade text-center" type="button">-</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

