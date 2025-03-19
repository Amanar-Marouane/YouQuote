<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouQuote API</title>
    <!-- Prism CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f8fafc;
            color: #1e293b;
            line-height: 1.6;
        }

        header {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 4rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.1;
        }

        h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            letter-spacing: -0.02em;
        }

        header p {
            font-size: 1.25rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }

        .container {
            flex: 1;
            padding: 3rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }

        .intro {
            margin-bottom: 4rem;
            background: white;
            padding: 2.5rem;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        h2 {
            color: #1e293b;
            margin-bottom: 1.5rem;
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: -0.01em;
        }

        .intro p {
            color: #475569;
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
        }

        .endpoints {
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 2.5rem;
            margin-bottom: 3rem;
        }

        .endpoint-group {
            margin-bottom: 3rem;
        }

        .endpoint-group h3 {
            margin-bottom: 1.5rem;
            color: #1e293b;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .endpoint {
            padding: 1.5rem;
            background-color: #f8fafc;
            border-left: 4px solid;
            margin-bottom: 1rem;
            border-radius: 0.5rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .endpoint:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .endpoint.get {
            border-left-color: #22c55e;
        }

        .endpoint.post {
            border-left-color: #3b82f6;
        }

        .endpoint.put {
            border-left-color: #f59e0b;
        }

        .endpoint.delete {
            border-left-color: #ef4444;
        }

        .method {
            display: inline-block;
            padding: 0.4rem 0.8rem;
            border-radius: 0.375rem;
            color: white;
            font-weight: 600;
            margin-right: 1rem;
            min-width: 70px;
            text-align: center;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .get .method {
            background-color: #22c55e;
        }

        .post .method {
            background-color: #3b82f6;
        }

        .put .method {
            background-color: #f59e0b;
        }

        .delete .method {
            background-color: #ef4444;
        }

        .endpoint-url {
            font-family: 'JetBrains Mono', 'Fira Code', monospace;
            font-weight: 600;
            color: #1e293b;
            font-size: 1.1rem;
        }

        .endpoint-description {
            margin-top: 0.75rem;
            font-size: 1rem;
            color: #475569;
        }

        .code-block {
            background-color: #1e293b;
            color: #f8fafc;
            padding: 1.5rem;
            border-radius: 0.5rem;
            font-family: 'JetBrains Mono', 'Fira Code', monospace;
            overflow-x: auto;
            margin: 1rem 0;
            font-size: 0.9rem;
            line-height: 1.5;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .code-snippet {
            background-color: #1e293b;
            border-radius: 1rem;
            padding: 2rem;
            margin: 2rem 0;
            font-family: 'JetBrains Mono', 'Fira Code', monospace;
            font-size: 0.9rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .code-snippet-header {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 1rem 2rem;
            border-radius: 1rem 1rem 0 0;
            margin: -2rem -2rem 2rem -2rem;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .params-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 1.5rem;
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .params-table th,
        .params-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .params-table th {
            background-color: #f8fafc;
            font-weight: 600;
            color: #1e293b;
        }

        .params-table tr:last-child td {
            border-bottom: none;
        }

        .params-table tr:hover td {
            background-color: #f8fafc;
        }

        .feature-list {
            list-style-type: none;
            padding-left: 1rem;
        }

        .feature-list li {
            margin-bottom: 0.75rem;
            position: relative;
            padding-left: 1.75rem;
            color: #475569;
        }

        .feature-list li:before {
            content: "•";
            color: #3b82f6;
            font-weight: bold;
            position: absolute;
            left: 0;
        }

        footer {
            text-align: center;
            padding: 2rem;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            margin-top: 4rem;
        }

        footer p {
            opacity: 0.9;
        }

        .request-example h4,
        .response-example h4 {
            color: #1e293b;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        @media (max-width: 768px) {
            .container {
                padding: 2rem 1rem;
            }

            h1 {
                font-size: 2.5rem;
            }

            .endpoint {
                padding: 1rem;
            }

            .code-snippet {
                padding: 1.5rem;
            }

            .code-snippet-header {
                margin: -1.5rem -1.5rem 1.5rem -1.5rem;
                padding: 0.75rem 1.5rem;
            }
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

            <div class="feature-list-container">
                <h3>Fonctionnalités principales</h3>
                <ul class="feature-list">
                    <li>Création et gestion de citations personnalisées</li>
                    <li>Système de catégorisation par tags</li>
                    <li>Recherche avancée et filtrage</li>
                    <li>Citations aléatoires pour inspiration</li>
                    <li>Système de likes et favoris</li>
                    <li>Authentification sécurisée</li>
                    <li>Permissions basées sur les rôles</li>
                </ul>
            </div>
        </section>

        <section class="endpoints">
            <h2>Points d'Accès (Endpoints)</h2>

            <div class="endpoint-group">
                <h3>Authentification</h3>
                <div class="endpoint post">
                    <span class="method">POST</span>
                    <span class="endpoint-url">/api/register</span>
                    <p class="endpoint-description">Créer un nouveau compte utilisateur et se connecter automatiquement.
                        Le token d'authentification sera stocké dans un cookie HTTP-only pour une sécurité optimale.</p>
                    <div class="request-example">
                        <h4>Exemple de requête:</h4>
                        <div class="code-block">
                            <pre><code class="language-json">{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}</code></pre>
                        </div>
                    </div>
                    <div class="response-example">
                        <h4>Exemple de réponse:</h4>
                        <div class="code-block">
                            <pre><code class="language-json">{
    "status": "Request Has Been Sent Successfully",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com"
        }
    }
}</code></pre>
                        </div>
                    </div>
                </div>

                <div class="endpoint post">
                    <span class="method">POST</span>
                    <span class="endpoint-url">/api/login</span>
                    <p class="endpoint-description">Connecter un utilisateur. Le token d'authentification sera stocké
                        dans un cookie HTTP-only pour une sécurité optimale.</p>
                    <div class="request-example">
                        <h4>Exemple de requête:</h4>
                        <div class="code-block">
                            <pre><code class="language-json">{
    "email": "john@example.com",
    "password": "password123"
}</code></pre>
                        </div>
                    </div>
                    <div class="response-example">
                        <h4>Exemple de réponse:</h4>
                        <div class="code-block">
                            <pre><code class="language-json">{
    "status": "Request Has Been Sent Successfully",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com"
        }
    }
}</code></pre>
                        </div>
                    </div>
                </div>

                <div class="endpoint post">
                    <span class="method">POST</span>
                    <span class="endpoint-url">/api/logout</span>
                    <p class="endpoint-description">Déconnecter l'utilisateur et invalider le token stocké dans le
                        cookie.</p>
                </div>
            </div>

            <div class="endpoint-group">
                <h3>Gestion des Catégories</h3>
                <div class="endpoint get">
                    <span class="method">GET</span>
                    <span class="endpoint-url">/api/category</span>
                    <p class="endpoint-description">Récupérer toutes les catégories disponibles. Nécessite une
                        authentification.</p>
                    <div class="response-example">
                        <h4>Exemple de réponse:</h4>
                        <div class="code-block">
                            <pre><code class="language-json">{
    "status": "Request Has Been Sent Successfully",
    "data": {
        "categories": [
            {
                "id": 1,
                "name": "Technology",
                "created_at": "2025-03-17 10:00:00",
                "updated_at": "2025-03-17 10:00:00"
            },
            {
                "id": 2,
                "name": "Health",
                "created_at": "2025-03-17 10:00:00",
                "updated_at": "2025-03-17 10:00:00"
            }
        ]
    }
}</code></pre>
                        </div>
                    </div>
                </div>
            </div>

            <div class="endpoint-group">
                <h3>Gestion des Citations (CRUD)</h3>
                <div class="endpoint get">
                    <span class="method">GET</span>
                    <span class="endpoint-url">/api/quote</span>
                    <p class="endpoint-description">Récupérer toutes les citations. Nécessite une authentification.</p>
                </div>
                <div class="endpoint post">
                    <span class="method">POST</span>
                    <span class="endpoint-url">/api/quote</span>
                    <p class="endpoint-description">Créer une nouvelle citation. Nécessite une authentification.</p>
                    <div class="request-example">
                        <h4>Exemple de requête:</h4>
                        <div class="code-block">
                            <pre><code class="language-json">{
    "type": "Book",
    "quote": "La vie est un mystère qu'il faut vivre, et non un problème à résoudre.",
    "author": "Gandhi",
    "category_id": [1, 3],
    "year": 1965,
    "publisher": "Éditions du Seuil"
}</code></pre>
                        </div>
                    </div>
                    <div class="params-table-container">
                        <h4>Paramètres:</h4>
                        <table class="params-table">
                            <thead>
                                <tr>
                                    <th>Champ</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Requis</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>type</td>
                                    <td>string</td>
                                    <td>Type de citation (Book, Article, Website)</td>
                                    <td>Oui</td>
                                </tr>
                                <tr>
                                    <td>quote</td>
                                    <td>string</td>
                                    <td>Texte de la citation (max: 1000 caractères)</td>
                                    <td>Oui</td>
                                </tr>
                                <tr>
                                    <td>author</td>
                                    <td>string</td>
                                    <td>Auteur de la citation</td>
                                    <td>Oui</td>
                                </tr>
                                <tr>
                                    <td>category_id</td>
                                    <td>array</td>
                                    <td>IDs des catégories (minimum 1)</td>
                                    <td>Oui</td>
                                </tr>
                                <tr>
                                    <td>year</td>
                                    <td>integer</td>
                                    <td>Année de publication (max: année actuelle)</td>
                                    <td>Pour Book et Article</td>
                                </tr>
                                <tr>
                                    <td>publisher</td>
                                    <td>string</td>
                                    <td>Éditeur (max: 255 caractères)</td>
                                    <td>Pour Book</td>
                                </tr>
                                <tr>
                                    <td>page_range</td>
                                    <td>integer</td>
                                    <td>Plage de pages (min: 1)</td>
                                    <td>Pour Article</td>
                                </tr>
                                <tr>
                                    <td>issue</td>
                                    <td>string</td>
                                    <td>Numéro d'édition (max: 100 caractères)</td>
                                    <td>Pour Article</td>
                                </tr>
                                <tr>
                                    <td>volume</td>
                                    <td>string</td>
                                    <td>Volume (max: 100 caractères)</td>
                                    <td>Pour Article</td>
                                </tr>
                                <tr>
                                    <td>url</td>
                                    <td>string</td>
                                    <td>URL source (format URL valide)</td>
                                    <td>Pour Website</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="endpoint put">
                    <span class="method">PUT</span>
                    <span class="endpoint-url">/api/quote/{id}</span>
                    <p class="endpoint-description">Mettre à jour une citation existante. Nécessite une authentification
                        et être le propriétaire ou un admin.</p>
                </div>
                <div class="endpoint delete">
                    <span class="method">DELETE</span>
                    <span class="endpoint-url">/api/quote/{id}</span>
                    <p class="endpoint-description">Supprimer une citation. Nécessite une authentification et être le
                        propriétaire ou un admin.</p>
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
                    <p class="endpoint-description">Obtenir les 10 citations les plus populaires. Nécessite une
                        authentification.</p>
                </div>
                <div class="endpoint get">
                    <span class="method">GET</span>
                    <span class="endpoint-url">/api/quote/{column}/{value}</span>
                    <p class="endpoint-description">Rechercher des citations par critère spécifique. Nécessite une
                        authentification.</p>
                </div>
            </div>

            <div class="endpoint-group">
                <h3>Gestion des Likes et Favoris</h3>
                <div class="endpoint get">
                    <span class="method">GET</span>
                    <span class="endpoint-url">/api/quote/likes</span>
                    <p class="endpoint-description">Récupérer les citations aimées par l'utilisateur. Nécessite une
                        authentification.</p>
                </div>
                <div class="endpoint post">
                    <span class="method">POST</span>
                    <span class="endpoint-url">/api/quote/like/{id}</span>
                    <p class="endpoint-description">Aimer/Ne plus aimer une citation. Nécessite une authentification.
                    </p>
                </div>
                <div class="endpoint get">
                    <span class="method">GET</span>
                    <span class="endpoint-url">/api/quote/favorites</span>
                    <p class="endpoint-description">Récupérer les citations favorites de l'utilisateur. Nécessite une
                        authentification.</p>
                </div>
                <div class="endpoint post">
                    <span class="method">POST</span>
                    <span class="endpoint-url">/api/quote/favorite/{id}</span>
                    <p class="endpoint-description">Ajouter/Retirer une citation des favoris. Nécessite une
                        authentification.</p>
                </div>
            </div>

            <div class="endpoint-group">
                <h3>Gestion des Tags</h3>
                <div class="endpoint get">
                    <span class="method">GET</span>
                    <span class="endpoint-url">/api/quote/tags</span>
                    <p class="endpoint-description">Récupérer des citations par tags. Nécessite une authentification.
                    </p>
                    <div class="request-example">
                        <h4>Exemple de requête:</h4>
                        <div class="code-block">
                            <pre><code class="language-json">{
    "tags": ["inspiration", "motivation"]
}</code></pre>
                        </div>
                    </div>
                </div>
            </div>

            <div class="endpoint-group">
                <h3>Fonctionnalités Admin</h3>
                <div class="endpoint get">
                    <span class="method">GET</span>
                    <span class="endpoint-url">/api/quote/pending</span>
                    <p class="endpoint-description">Récupérer les citations en attente de validation. Nécessite une
                        authentification et un rôle Admin.</p>
                </div>
                <div class="endpoint post">
                    <span class="method">POST</span>
                    <span class="endpoint-url">/api/quote/valid/{id}</span>
                    <p class="endpoint-description">Valider une citation. Nécessite une authentification et un rôle
                        Admin.</p>
                </div>
            </div>
        </section>

        <section class="usage-example">
            <h2>Exemple d'utilisation</h2>
            <div class="code-snippet">
                <div class="code-snippet-header">Authentification et récupération des citations</div>
                <pre><code class="language-javascript">const login = async () => {
    const response = await fetch('https://youquote-api.example.com/api/login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            email: 'utilisateur@example.com',
            password: 'motdepasse123'
        })
    });
    const data = await response.json();
    return data.token;
};

const getQuotes = async (token) => {
    const response = await fetch('https://youquote-api.example.com/api/quote', {
        headers: { 'Authorization': `Bearer ${token}` }
    });
    return await response.json();
};

login()
    .then(token => getQuotes(token))
    .then(quotes => console.log(quotes))
    .catch(error => console.error('Erreur:', error));</code></pre>
            </div>

            <div class="code-snippet">
                <div class="code-snippet-header">Création d'une nouvelle citation</div>
                <pre><code class="language-javascript">const createQuote = async (token, quoteData) => {
    const response = await fetch('https://youquote-api.example.com/api/quote', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`
        },
        body: JSON.stringify(quoteData)
    });
    return await response.json();
};

const quoteData = {
    type: 'Book',
    quote: 'La vie est un mystère qu\'il faut vivre, et non un problème à résoudre.',
    author: 'Gandhi',
    category_id: [1, 3],
    year: 1965,
    publisher: 'Éditions du Seuil'
};

createQuote(token, quoteData)
    .then(result => console.log('Citation créée:', result))
    .catch(error => console.error('Erreur:', error));</code></pre>
            </div>
        </section>
    </div>

    <footer>
        <p>YouQuote API &copy; 2025 | Développée avec Laravel</p>
    </footer>

    <!-- Prism JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-json.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-javascript.min.js"></script>
    <script>
        // Initialize Prism
        Prism.highlightAll();
    </script>
</body>

</html>
