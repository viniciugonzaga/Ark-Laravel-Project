<nav>
    <a href="/">Home</a>
    <a href="/fichas">Fichas</a>
    <a href="/rolagens">Rolagens</a>
    <a href="/regras">Regras</a>

    @auth
        <a href="/perfil">Perfil</a>
        <form method="POST" action="/logout">
            @csrf
            <button>Sair</button>
        </form>
    @else
        <a href="/login">Login</a>
    @endauth
</nav>