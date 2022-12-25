<div class="row justify-content-end">
    <div class="col-12">
        <form action="{{$action}}" method="GET" id="formSearch">
            @csrf
            <div class="input-group mb-3">
                <input type="search" id="searchData" name="search" class="form-control border-end-0 border-secondary" placeholder="Search..." aria-describedby="button-search" value="{{request('search') ?? ""}}">
                <button class="btn btn-outline-secondary border-start-0" type="submit" id="button-search">
                    <i class="material-icons">search</i>
                </button>
            </div>
        </form>
    </div>
</div>