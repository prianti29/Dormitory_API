<ul>
    <li><a href="{{ url('api/dashboard') }}">Home</a></li>
    <li><a href="{{ url('api/member') }}">Member</a></li>
    <li><a href="{{ url('api/meal') }}">Meal</a></li>
    <li><a href="{{ url('api/cost') }}">Cost</a></li>
    <li><a href="{{ url('api/account') }}">Acounts</a></li>
    <li>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-link" style="padding-top: 15px;"><span
                    class="glyphicon glyphicon-log-out"></span> Logout </button>
        </form>
    </li>
</ul>
