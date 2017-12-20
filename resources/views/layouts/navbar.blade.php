<div class="blog-masthead">
	<div class="container">
		<nav class="nav">
			<a class="nav-link" href="/">Home</a>
			@auth
				<a class="nav-link" href="/posts/create">Create a Post</a>
			@endauth
			@guest
				<a href="{{ route('login') }}" class="nav-link ml-auto">Login</a>
				<a href="{{ route('register') }}" class="nav-link">Register</a>
			@else
				<a href="#" class="dropdown-toggle ml-auto nav-link" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
			@endguest


		</nav>
	</div>
</div>