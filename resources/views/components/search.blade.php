<div class="row justify-content-end">
    <div class="col-12">
        <form action="{{$action}}" method="GET" id="formSearch">
            @csrf
            <div class="input-group mb-3">
                <div id="button-search">
                    <i class="material-icons">search</i>
                </div>
                <input type="search" id="searchData" name="search" class="form-control border-start-0 border-secondary" onkeyup="search()" placeholder="Search..." aria-describedby="button-search" value="{{request('search') ?? ""}}">
            </div>
        </form>
    </div>
</div>
