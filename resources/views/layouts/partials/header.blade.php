<div class="header">
    <span class="menu-toggle">&#9776;</span>
    <div class="profile">
        <span>{{ Auth::user()->name ?? 'Admin' }}</span>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="logout-button">Logout</button>
        </form>
    </div>
</div>
