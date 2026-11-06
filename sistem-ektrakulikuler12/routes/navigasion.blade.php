<nav class="bottom-nav">

    <a href="{{ route('dashboard') }}"
       class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">

        <i class="fa-solid fa-house"></i>

        <span>Home</span>

    </a>


    <a href="{{ route('ekstrakurikuler') }}"
       class="{{ request()->routeIs('ekstrakurikuler*') ? 'active' : '' }}">

        <i class="fa-solid fa-users"></i>

        <span>Ekstrakurikuler</span>

    </a>


    <a href="{{ route('penilaian') }}"
       class="{{ request()->routeIs('penilaian*') ? 'active' : '' }}">

        <i class="fa-solid fa-clipboard-list"></i>

        <span>Penilaian</span>

    </a>


    <a href="{{ route('profil') }}"
       class="{{ request()->routeIs('profil') ? 'active' : '' }}">

        <i class="fa-solid fa-user"></i>

        <span>Profil</span>

    </a>

</nav>