<div class="row mb-3">
    <div class="col-md-4"><strong>Started Working:</strong></div>
    <div class="col-md-8 d-flex justify-content-between">
        <span class="data">{{ $user->photographer->started_working }}</span>
        <input type="date" class="form-control edit-field" name="started_working" style="display: none;" value="{{ $user->photographer->started_working }}">
        <span class="edit-btn" onclick="editField(this)"><i class="bi bi-pencil-fill"></i></span>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4"><strong>About:</strong></div>
    <div class="col-md-8 d-flex justify-content-between">
        <span class="data">{{ $user->photographer->about }}</span>
        <input type="text" class="form-control edit-field" name="about" style="display: none;" value="{{ $user->photographer->about }}">
        <span class="edit-btn" onclick="editField(this)"><i class="bi bi-pencil-fill"></i></span>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4"><strong>Rating:</strong></div>
    <div class="col-md-8 d-flex justify-content-between">
        <span class="data">{{ $user->photographer->rating }}</span>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4"><strong>Skills:</strong></div>
    <div class="col-md-8 d-flex justify-content-between">
        <span class="data">{{ $user->photographer->skill1 }}</span>
        <input type="text" class="form-control edit-field" name="skill1" style="display: none;" value="{{ $user->photographer->skill1 }}">
        <span class="data">{{ $user->photographer->skill2 }}</span>
        <input type="text" class="form-control edit-field" name="skill2" style="display: none;" value="{{ $user->photographer->skill2 }}">
        <span class="data">{{ $user->photographer->skill3 }}</span>
        <input type="text" class="form-control edit-field" name="skill3" style="display: none;" value="{{ $user->photographer->skill3 }}">
        <span class="edit-btn" onclick="editField(this)"><i class="bi bi-pencil-fill"></i></span>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4"><strong>Number of Jobs:</strong></div>
    <div class="col-md-8 d-flex justify-content-between">
        <span class="data">{{ $user->photographer->number_of_jobs }}</span>
    </div>
</div>
<button class="update-photo-btn" id="editAccountBtn" disabled onclick="document.getElementById('editAccountForm').submit()">Edit Account</button>

<form id="editAccountForm" action="{{ route('profile.update') }}" method="POST" style="display: none;">
    @csrf
    @method('PUT')
    <input type="hidden" name="started_working" id="started_working" value="{{ $user->photographer->started_working }}">
    <input type="hidden" name="about" id="about" value="{{ $user->photographer->about }}">
    <input type="hidden" name="rating" id="rating" value="{{ $user->photographer->rating }}">
    <input type="hidden" name="skills[]" id="skill1" value="{{ $user->photographer->skill1 }}">
    <input type="hidden" name="skills[]" id="skill2" value="{{ $user->photographer->skill2 }}">
    <input type="hidden" name="skills[]" id="skill3" value="{{ $user->photographer->skill3 }}">
    <input type="hidden" name="number_of_jobs" id="number_of_jobs" value="{{ $user->photographer->number_of_jobs }}">
</form>
