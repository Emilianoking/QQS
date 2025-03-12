<h1>Panel de Admin, {{ Auth::user()->nombre }}</h1>
<form method="POST" action="{{ url('/logout') }}">@csrf <button type="submit">Cerrar sesión</button></form>