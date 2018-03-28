<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="review-modal-name">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="list-group" id="reviews">

        </div>
        <a href='#'' class='list-group-item list-group-item-action flex-column align-items-start'>
           <form method="POST" action="{{url('places')}}"> 
            {{csrf_field()}}
          <input class="form-control" type="text" placeholder="Nama" name="name" required>
          <input class="form-control" type="text" placeholder="Yuk Bantu Review" name="review">
          <input id="review-modal-placeid" type="hidden" name="place_id" value="">
          <select class="form-control" name="rating" required>
            <option value="" disabled selected>Pilih Rating</option>
            @for($i =1 ;$i <=5;$i++ )
              <option value="{{$i}}">{{$i}}</option>
            @endfor
          </select>
          <button class="btn btn-primary">Save changes</button>
        </form>
        </a>
      </div>
      <div class="modal-footer">
        
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>