# DefORM

DefORM est un *Object-relational mapping* en PHP.

## Configuration

Créer un fichier `config.json` dans votre projet 

```json
{
    "host": "hostname",
    "name": "dbname",
    "user": "root",
    "pass": "root"
}
```

## l'ORM

### Créer un model

Admettons que nous avons une table de films. Cette table a un *id* et un *titre* et est déjà créé dans notre base de donnée avec les champs `id` et `title`.

##### Entity

Nous créons un nouveau fichier `Film.php` dans un dossier `Entity`.

Nous spécifions le `namespace` de notre entité film. Notre `namespace` est `App\Entity`.

Pour que notre entité profite des fonctionnalité de l'ORM, notre entité film héritera de la class `Model` de defORM. Nous spécifions à notre class d'utiliser `DefORM\Model`.

```php
namespace App\Entity;

use DefORM\Model;

class Film extends Model 
{
    protected $id;

    protected $title;

    public function getId() : int 
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getTitle() : string 
    {
        return $this->title;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }
}
```

Nous créons nos propriété **protected** `$id` et `$title` ainsi que les `getters` et `setter`. Les propriétés **protected** permettent à la class `Model` d'accéder à ces dernières.

##### Repository

Le **repository** est le *carton qui contient tous nos films* et qui permet de les recupérer selon nos besoin.

```php
namespace App\Repository;

use \PDO;
use DefORM\Repository;

class FilmRepository extends Repository {

    private static $instance = null;

    private function __construct() { }

    public static function getRepository()
    {
        if(is_null(self::$instance))
        {
            self::$instance = new FilmRepository;
            return self::$instance;
        }

        return self::$instance;
    }
}
```

Nous ajoutons dans les *repository* des fonctions qui s'occupent de faire des requêtes et nous renvoyer une ou plusieurs informations de la base de données, en l'occurance, des films dans notre cas. Les fonctions suivantes peuvent nous être utiles. 

Retourne tous les films de notre table :

```php
public function getAll()
{
    $req = $this->db()->query("SELECT * FROM films ORDER BY id DESC");
    $req->setFetchMode(PDO::FETCH_CLASS, 'App\\Entity\\Film');
    $result = $req->fetchAll();

    return $result;
}
```

Retourne un film de notre table par son `id` :

```php
public function getById(int $id)
{
    $req = $this->db()->prepare("SELECT * FROM films WHERE id = ?");
    $req->execute([$id]);
    $req->setFetchMode(PDO::FETCH_CLASS, 'App\\Entity\\Film');
    $result = $req->fetch();
    
    return $result;
}
```

### Utiliser le model

##### Create

```php
use App\Entity\Film;

$film = new Film;
$film->setTitle('Nouveau film');
$film->save();
```

##### Read

```php
use App\Repository\FilmRepository;

$films = FilmRepository::getRepository();
$film = $films->getById('1');
$film->getTitle(); // return $title
```

##### Update

```php
use App\Repository\FilmRepository;

$films = FilmRepository::getRepository();
$film = $films->getById('1');
$film->setTitle('Nouveau title');
$film->save();
```
