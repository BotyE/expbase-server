

<?php
// header('Content-type: json/application; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
// require 'connect.php';

// $type = $_GET['q'];

// if($type === 'comments') {


// $comments = mysqli_query($connection, "SELECT * FROM `comments`");

// $commentsList = [];

// while($comment = mysqli_fetch_assoc($comments)) {
//     $commentsList[] = $comment;
// }

// echo json_encode($commentsList);

// }
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Selective\BasePath\BasePathMiddleware;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

// Add Slim routing middleware
$app->addRoutingMiddleware();

// Set the base path to run the app in a subdirectory.
// This path is used in urlFor().
$app->add(new BasePathMiddleware($app));
$app->setBasePath('/newapi');
$app->addErrorMiddleware(true, true, true);
$app->addBodyParsingMiddleware();

// Define app routes
$app->get('/read', function (Request $request, Response $response) {
    require 'connect.php';
    $comments = mysqli_query($connection, "SELECT * FROM `comments` ORDER BY created DESC");

$commentsList = [];

while($comment = mysqli_fetch_assoc($comments)) {
    $commentsList[] = $comment;
}
    $response->withStatus(200)->withHeader('Content-Type', 'application/json')->getBody()->write(json_encode($commentsList));
    return $response;
})->setName('root');

$app->post('/create', function ($request, $response, $args) {  
    require 'connect.php';
    $parsed = $request->getParsedBody(); 
    $name = $parsed['name'];
    $comment = $parsed['comment']; 
    $created = date("Y-m-d H:i:s");
    $query = "INSERT INTO `comments` (name, comment, created) VALUES ('$name','$comment','$created')";
    $comments = mysqli_query($connection, $query);
    $commentos = mysqli_query($connection, "SELECT * FROM `comments` ORDER BY created DESC");
    $commentsList = [];
    while($comment = mysqli_fetch_assoc($commentos)) {
        $commentsList[] = $comment;
    }
    $response->getBody()->write(json_encode($commentsList));
    return $response;
});


$app->delete('/delete/{id}', function ($request, $response, $args) {
    require 'connect.php';
    $id = $args['id'];
    $query = "DELETE FROM `comments` WHERE id = $id";
    $delete = mysqli_query($connection, $query);
    $comments = mysqli_query($connection, "SELECT * FROM `comments` ORDER BY created DESC");
    
    $commentsList = [];

    while($comment = mysqli_fetch_assoc($comments)) {
        $commentsList[] = $comment;
    }
        $response->withStatus(200)->withHeader('Content-Type', 'application/json')->getBody()->write(json_encode($commentsList));
        return $response;
});

// Run app
$app->run();
?> 