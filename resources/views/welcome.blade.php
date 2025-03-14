<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouQuote API</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f5f5f5;
            color: #333;
        }

        header {
            background-color: #4a69bd;
            color: white;
            padding: 2rem;
            text-align: center;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .container {
            flex: 1;
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
            overflow-y: auto;
        }

        .intro {
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .endpoints {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        h2 {
            color: #4a69bd;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #f0f0f0;
        }

        .endpoint-group {
            margin-bottom: 2rem;
        }

        .endpoint-group h3 {
            margin-bottom: 1rem;
            color: #546de5;
        }

        .endpoint {
            padding: 1rem;
            background-color: #f8f9fa;
            border-left: 4px solid;
            margin-bottom: 1rem;
            border-radius: 0 4px 4px 0;
        }

        .endpoint.get {
            border-left-color: #20bf6b;
        }

        .endpoint.post {
            border-left-color: #3867d6;
        }

        .endpoint.put {
            border-left-color: #f7b731;
        }

        .endpoint.delete {
            border-left-color: #eb3b5a;
        }

        .method {
            display: inline-block;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            color: white;
            font-weight: bold;
            margin-right: 1rem;
            min-width: 60px;
            text-align: center;
        }

        .get .method {
            background-color: #20bf6b;
        }

        .post .method {
            background-color: #3867d6;
        }

        .put .method {
            background-color: #f7b731;
        }

        .delete .method {
            background-color: #eb3b5a;
        }

        .endpoint-url {
            font-family: 'Courier New', monospace;
            font-weight: bold;
        }

        .endpoint-description {
            margin-top: 0.5rem;
            font-size: 0.9rem;
        }

        .code-block {
            background-color: #2d3436;
            color: #dfe6e9;
            padding: 1rem;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            overflow-x: auto;
            margin-bottom: 1rem;
        }

        footer {
            text-align: center;
            padding: 1rem;
            background-color: #4a69bd;
            color: white;
        }

        .bonus {
            background-color: #ffeaa7;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }

        .bonus h3 {
            color: #d35400;
        }
    </style>
</head>

<body>
    <header>
        <h1>YouQuote API</h1>
        <p>Gérez facilement vos citations inspirantes</p>
    </header>

    <div class="container">
        <section class="intro">
            <h2>Introduction</h2>
            <p>Bienvenue sur l'API YouQuote, une solution puissante pour gérer des citations inspirantes. Cette API vous
                permet de créer, lire, mettre à jour et supprimer des citations, ainsi que d'obtenir des citations
                aléatoires et de filtrer les citations en fonction de leur longueur.</p>
            <p>En plus des fonctionnalités CRUD de base, YouQuote suit la popularité des citations les plus demandées et
                offre des fonctionnalités bonus comme la génération d'images pour les citations populaires et un système
                d'authentification sécurisé.</p>
        </section>

        <section class="endpoints">
            <h2>Points d'Accès (Endpoints)</h2>

            <div class="endpoint-group">
                <h3>Authentification</h3>
                <div class="endpoint post">
                    <span class="method">POST</span>
                    <span class="endpoint-url">/api/register</span>
                    <p class="endpoint-description">Créer un nouveau compte utilisateur.</p>
                </div>
                <div class="endpoint post">
                    <span class="method">POST</span>
                    <span class="endpoint-url">/api/login</span>
                    <p class="endpoint-description">Se connecter.</p>
                </div>
                <div class="endpoint post">
                    <span class="method">POST</span>
                    <span class="endpoint-url">/api/logout</span>
                    <p class="endpoint-description">Se déconnecter .</p>
                </div>
            </div>

            <div class="endpoint-group">
                <h3>Gestion des Citations (CRUD)</h3>
                <div class="endpoint get">
                    <span class="method">GET</span>
                    <span class="endpoint-url">/api/quotes</span>
                    <p class="endpoint-description">Récupérer toutes les citations. Nécessite une authentification.</p>
                </div>
                <div class="endpoint post">
                    <span class="method">POST</span>
                    <span class="endpoint-url">/api/quote</span>
                    <p class="endpoint-description">Créer une nouvelle citation. Nécessite une authentification.</p>
                </div>
                <div class="endpoint put">
                    <span class="method">PUT</span>
                    <span class="endpoint-url">/api/quote/{id}</span>
                    <p class="endpoint-description">Mettre à jour une citation existante. Nécessite une
                        authentification.</p>
                </div>
                <div class="endpoint delete">
                    <span class="method">DELETE</span>
                    <span class="endpoint-url">/api/quote/{id}</span>
                    <p class="endpoint-description">Supprimer une citation. Nécessite une authentification.</p>
                </div>
            </div>

            <div class="endpoint-group">
                <h3>Fonctionnalités Spéciales</h3>
                <div class="endpoint get">
                    <span class="method">GET</span>
                    <span class="endpoint-url">/api/quote/random/{limit}</span>
                    <p class="endpoint-description">Obtenir un nombre spécifié de citations aléatoires. Nécessite une
                        authentification.</p>
                </div>
                <div class="endpoint get">
                    <span class="method">GET</span>
                    <span class="endpoint-url">/api/quote/filter/{count}</span>
                    <p class="endpoint-description">Filtrer les citations par nombre de mots. Nécessite une
                        authentification.</p>
                </div>
                <div class="endpoint get">
                    <span class="method">GET</span>
                    <span class="endpoint-url">/api/quote/popular</span>
                    <p class="endpoint-description">Obtenir les citations les plus populaires. Nécessite une
                        authentification.</p>
                </div>
                <div class="endpoint get">
                    <span class="method">GET</span>
                    <span class="endpoint-url">/api/quote/{column}/{value}</span>
                    <p class="endpoint-description">Rechercher des citations par critère spécifique. Nécessite une
                        authentification.</p>
                </div>
            </div>
        </section>
    </div>

    <footer>
        <p>YouQuote API &copy; 2025 | Développée avec Laravel</p>
    </footer>
</body>

</html>
