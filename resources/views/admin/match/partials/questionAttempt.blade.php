<!-- All Active Modal -->
<div class="modal fade" id="all_active" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-primary">
                <h5 class="modal-title">@lang('Active Confirmation')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <p>@lang("Are you really want to active the Question")</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal"><span>@lang('No')</span></button>
                <form action="" method="post">
                    @csrf
                    <a href="" class="btn btn-primary active-yes"><span>@lang('Yes')</span></a>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- All Inactive Modal -->
<div class="modal fade" id="all_inactive" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-primary">
                <h5 class="modal-title">@lang('DeActive Confirmation')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <p>@lang("Are you really want to Deactive the Question")</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal"><span>@lang('No')</span></button>
                <form action="" method="post">
                    @csrf
                    <a href="" class="btn btn-primary inactive-yes"><span>@lang('Yes')</span></a>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- All Close Modal -->
<div class="modal fade" id="all_close" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-primary">
                <h5 class="modal-title">@lang('Close Confirmation')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <p>@lang("Are you really want to close the Question")</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal"><span>@lang('No')</span></button>
                <form action="" method="post">
                    @csrf
                    <a href="" class="btn btn-primary close-yes"><span>@lang('Yes')</span></a>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Edit MODAL --}}
<div id="editModal" class="modal fade show" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-primary">
                <h5 class="modal-title">@lang('Edit Question')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" class="questionId" name="questionId" value="">
                    <div class="form-group">
                        <label>@lang('Name')</label>
                        <input type="text" class="form-control editName" name="name" value="" required>
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="text-dark">@lang('Status') </label>
                        <select id="editStatus" class="form-control editStatus"
                                name="status" required>
                            <option value="">@lang('Select Status')</option>
                            <option value="1">@lang('Active')</option>
                            <option value="0">@lang('Pending')</option>
                            <option value="2">@lang('Closed')</option>
                        </select>
                        @error('status')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>@lang('End Date')</label>
                        <input type="datetime-local" class="form-control editTime" name="end_time"
                               id="editEndDate" required>
                        @error('end_time')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">@lang('Update')</button>
                    <button type="button" class="btn btn-dark" data-dismiss="modal">@lang('Close')</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Remove MODAL --}}
<div id="delete-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="primary-header-modalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-primary">
                <h4 class="modal-title" id="primary-header-modalLabel">@lang('Delete Confirmation')
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                </button>
            </div>
            <div class="modal-body">
                <p>@lang('Are you sure to delete this?')</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">@lang('Close')</button>
                <form action="" method="post" class="deleteRoute">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-primary">@lang('Yes')</button>
                </form>
            </div>
        </div>
    </div>
</div>


@push('js')
    <script>
        'use strict'

        $(document).on('click', '.editBtn', function () {
            var modal = $('#editModal');
            var obj = $(this).data('resource');
            modal.find('input[name=name]').val(obj.name);
            $('.questionId').val(obj.id);
            $('#editStatus').val(obj.status);
            $('#editEndDate').val(obj.end_time);
            modal.find('form').attr('action', $(this).data('action'));
            modal.modal('show');
        });

        $(document).on('shown.bs.modal', '#editModal', function (e) {
            $(document).off('focusin.modal');
        });

        $(document).on('click', '.notiflix-confirm', function () {
            var route = $(this).data('route');
            $('.deleteRoute').attr('action', route)
        })


        $(document).on('click', '#check-all', function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        $(document).on('change', ".row-tic", function () {
            let length = $(this).length;
            let checkedLength = $(".row-tic:checked").length;
            if (length == checkedLength) {
                $('#check-all').prop('checked', true);
            } else {
                $('#check-all').prop('checked', false);
            }
        });

        //multiple active
        $(document).on('click', '.active-yes', function (e) {
            e.preventDefault();
            var allVals = [];
            $(".row-tic:checked").each(function () {
                allVals.push($(this).attr('data-id'));
            });

            var strIds = allVals;

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: "{{ route('admin.question-active') }}",
                data: {strIds: strIds},
                datatType: 'json',
                type: "post",
                success: function (data) {
                    location.reload();

                },
            });
        });

        //multiple deactive
        $(document).on('click', '.inactive-yes', function (e) {
            e.preventDefault();
            var allVals = [];
            $(".row-tic:checked").each(function () {
                allVals.push($(this).attr('data-id'));
            });
            var strIds = allVals;
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: "{{ route('admin.question-deactive') }}",
                data: {strIds: strIds},
                datatType: 'json',
                type: "post",
                success: function (data) {
                    location.reload();

                }
            });
        });

        //multiple close
        $(document).on('click', '.close-yes', function (e) {
            e.preventDefault();
            var allVals = [];
            $(".row-tic:checked").each(function () {
                allVals.push($(this).attr('data-id'));
            });
            var strIds = allVals;
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: "{{ route('admin.question-close') }}",
                data: {strIds: strIds},
                datatType: 'json',
                type: "post",
                success: function (data) {
                    location.reload();

                }
            });
        });

    </script>
@endpush
