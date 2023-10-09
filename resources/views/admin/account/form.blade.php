<div class="box-body">
    <div class="form-group">
        <label for="">名稱: *</label>
        <input type="text" name="name" value="{{ $admin->present()->getFormValue('name') }}"
               class="form-control" placeholder="請填寫名稱"/>
    </div>
    <div class="form-group">
        <label for="">帳號: *</label>
        <input type="text" name="email" value="{{ $admin->present()->getFormValue('email') }}"
               class="form-control" placeholder='請填寫email'/>
    </div>
    <div class="form-group">
        <label for="">群組: *</label>
        <select name="role[]" class="form-control select2" style="width: 100%;" multiple="multiple">
            @foreach($roleList as $key=>$displayName)
                @if($admin->present()->getRoleSelected('role', $key))
                    <option value="{{ $key }}" selected>{{ $displayName }}</option>
                @else
                    <option value="{{ $key }}">{{ $displayName }}</option>
                @endif
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="">備註</label>
        <input type="text" name="comment" value="{{ $admin->present()->getFormValue('comment') }}"
               class="form-control" placeholder="請填寫備註"/>
    </div>
    <div class="row">
        <div class="form-group col-md-3">
            <label for="">狀態: *</label>
            <select name="status" class="form-control select2" style="width: 100%;">
                @foreach($admin->present()->getStatusList() as $statusId=>$text)
                    @if($admin->present()->getFormSelected('status', $statusId))
                        <option value="{{ $statusId }}" selected>{{ $text }}</option>
                    @else
                        <option value="{{ $statusId }}">{{ $text }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
</div>