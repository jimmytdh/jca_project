<div class="float-end">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addContestant">
        +
      </button>
</div>


  
<form method="post" action="{{ route('contestant.create') }}" enctype="multipart/form-data">
    @csrf
    @method('post')

  <div class="modal fade" id="addContestant" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Contestant registration</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
 
                <div class="modal-body">
        
                    <div class="mb-3">
                        <label for="name" class="form-label">Contestant Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter name here" name="name" required>
                    </div>
        
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" placeholder="Enter address here" name="address" required>
                    </div>
        
                    <div class="mb-3">
                        <label for="photo" class="form-label">Photo</label>
                        <input type="file" class="form-control" id="photo" name="photo" required>
                    </div>
        
                    <div class="mb-3">
                        <label for="contestantNum" class="form-label">Number</label>
                        <input type="number" class="form-control" id="contestantNum" placeholder="Enter number here" name="contestantNum" required>
                    </div>
        
                    <div class="d-flex gap-2">
                        <div class="mb-3">
                            <label for="age" class="form-label">Age</label>
                            <input type="number" class="form-control" id="age" placeholder="Enter age here" name="age" required>
                        </div>
            
                        <div class="mb-3">
                            <label for="chest" class="form-label">Chest</label>
                            <input type="number" class="form-control" id="chest" placeholder="Enter chest measurement here" name="chest" required>
                        </div>
            
                        <div class="mb-3">
                            <label for="waist" class="form-label">Waist</label>
                            <input type="number" class="form-control" id="waist" placeholder="Enter waist measurement here" name="waist" required>
                        </div>
                    </div>
        
                    <div class="d-flex gap-2">
                        <div class="mb-3">
                            <label for="height" class="form-label">Height</label>
                            <input type="number" class="form-control" id="height" placeholder="Enter height here" name="height" required>
                        </div>
            
                        <div class="mb-3">
                            <label for="weight" class="form-label">Weight</label>
                            <input type="number" class="form-control" id="weight" placeholder="Enter weight here" name="weight" required>
                        </div>
            
                        <div class="mb-3">
                            <label for="hips" class="form-label">Hips</label>
                            <input type="number" class="form-control" id="hips" placeholder="Enter hips measurement here" name="hips" required>
                        </div>
                    </div>
        
                    <input type="hidden" class="form-control" name="eventID" value="{{ $event->id }}">
        
                </div>
           



        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

</form>