# Deeplomacy

A game about friendship and betrayal deep under the surface of the ocean.

## Getting started

- Clone the git repository by opening a terminal and running:

`git clone https://github.com/sytzez/deeplomacy.git`

- Enter the project directory:

`cd deeplomacy`

- Install composer packages:

`composer install`

- Customize the database connection info inside your `.env`, for example:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=deeplomacy
DB_USERNAME=root
DB_PASSWORD=
```

- Run the migrations:

`php artisan migrate:fresh`

- Start the local server (if not using valet):

`php artisan serve`

- Run the scheduler if you want games to progress properly:

`php artisan schedule:work`

- Open the app in your browser:

[http://127.0.0.1:8000](http://127.0.0.1:8000)

## Game rules

Each player controls a submarine on the game grid. A player can only see around them up until a certain distance.
*Action points* are distributed regularly to all players, which they can use to perform actions.

The following actions are possible:

- *Moving* — Moves the submarine to another cell on the grid. Longer distances cost more action points. 
- *Attacking* — Targets another submarine, a probabilistic calculation is made to determine whether the target lives or dies. 
  The range is unlimited, as long as the target is visible to the attacker.
- *Donating action points* — Transfers a chosen amount of action points to another submarine.
- *Sharing sonar* — Permanently grants another submarine access to the player's own field of view.

The strategy in the game lies in deciding whether to attack or befriend other players. 
There is much advantage in playing within a group over playing alone, but eventually there can only be one survivor to win the game.

## File structure

Some noteworthy  directories.

- [/app](app) — The backend Laravel project.
    - [/Adapters](app/Adapters) — These classes represent the layer adapting our Laravel models to their Game contracts.
    - [/Factories](app/Factories) — They turn HTTP requests into objects we need for the game.
    - [/Game](app/Game) — Contains the high level logic for the game itself, agnostic of our framework.
        - [/Actions](app/Game/Actions) — Actions a player can take to mutate the state of the game.
        - [/Contracts](app/Game/Contracts) — These contracts (interfaces) should be implemented by the lower level framework to work with the game logic.
        - [/Data](app/Game/Data) — Immutable data objects representing things inside the game.
        - [/Services](app/Game/Services) — These services perform the hard business logic of the game.
        - [/Validators](app/Game/Validators) — The validators check whether certain actions are valid in the game.
        - [/Strategies](app/Game/Strategies) — Currently only used for placing new submarines in the game. Various placement strategies could be chosen.
    - [/Http](app/Http) — Our controllers, form requests, middleware, resources etc.
    - [/Models](app/Models) — The models represent the content of our database, standard Laravel stuff.
    - [/Jobs](app/Jobs) — Things that need to be done regularly, like distributing action points to all players.
- [/resources/angular](resources/angular/src/app) — The frontend Angular project.
    - [/pages](resources/angular/src/app/components) - Custom UI components used in the app, including the game map.
    - [/data](resources/angular/src/app/data) - Data interfaces used in the Angular services.
    - [/models](resources/angular/src/app/models) - Data interfaces representing models returned from the backend.
    - [/pages](resources/angular/src/app/pages) - The two pages for our app: the index and the gameplay view.
    - [/services](resources/angular/src/app/services) - These services send and receive data to and from the backend.

## Design patterns utilized

### Adapter pattern

To keep the gameplay module (everything within [/app/Game](app/Game)) agnostic of framework-specific classes and practices,
the `App/Game` namespace provides contracts to interface with the framework in a useful way.

Adapter classes have been implemented for each Laravel model to make them work in a way that satisfies their corresponding game contract.
For example, the game specifies a [SubmarineContract](app/Game/Contracts/SubmarineContract.php) with all the methods it needs to be able to call on a submarine.
The [SubmarineAdapter](app/Adapters/SubmarineAdapter.php) class then wraps around the [Submarine](app/Models/Submarine.php) model class, and implements the contract's methods using Laravel-style operations, such as magic properties.

This way the Laravel models don't need to know about what the game needs, and the game doesn't need to know the specifics of Laravel models.

### Strategy pattern

Some details of the game could be implemented in various different ways, and these ways could be changed and switched back-and-forth over time.
However, we don't want the code that relies on these details to suffer instability from these changes, we only want to edit the relevant class.

An example of this is the placement of new submarines on the game grid. There are many ways, both simple and complex, to calculate the ideal position at which a new player should enter the game.
The rest of the game code couldn't care less *how* this is done, it just needs the submarine to be placed.

To facilitate this separation, a [PlacementStrategyContract](app/Game/Contracts/PlacementStrategyContract.php) interface is used by the rest of the game logic to do this placement.
A specific placement strategy class instance implementing this contract, such as [RandomPlacementStrategy](app/Game/Strategies/RandomPlacementStrategy.php) is passed to the [JoinGameAction->do()](app/Game/Actions/JoinGameAction.php) method,
leaving the caller of the method to decide what strategy will be used. At any point new strategies can be created, without having to change the code dependent on submarine placement.

### Action pattern

The easiest way to understand the rules of a game, especially a (semi) turn based one, is in terms of actions performed by the players, which mutate the state of the game.

Using the action pattern with a single public `->do()` method makes it very clear to the reader what these classes will do.
For example: 
[JoinGameAction](app/Game/Actions/JoinGameAction.php), 
[AttackSubmarineAction](app/Game/Actions/AttackSubmarineAction.php), 
[GiveActionPointsAction](app/Game/Actions/GiveActionPointsAction.php).

The idea is similar to the Controller pattern, as the classes themselves don't contain much logic.
The Action classes usually only call a validation method, and a service method to facilitate the action.
Instead of taking an HTTP request, they take the intended move of the game player, and instead of returning a response, they mutate the state of the game.

### Factory pattern

The server receives HTTP requests, but the game wants to get information about what to do in the form of specific action data objects.
Factories contain the code to take the HTTP request and output the correct action data, so that neither our HTTP controllers nor our game action classes have to bother with this transformation.

### Immutable objects

The gameplay code provides some immutable data classes to represent things that are part of the game, like action points, positions, action data, and more.
Being immutable makes the code using these classes less prone to bugs. If they were mutable, one part of the code could make changes to an instance, while another part of the code could expect the instance to remain the same.
With immutable objects you can pass the instance into the method of another class, even through an interface without being aware of the implementation of the method,
and be assured the instance will not be modified.

## Usage of SOLID principles

### Single responsibility

As much as possible, each class only does one thing. There are separate classes for validation, creating objects (factories), doing specific things (services), etc.
All the business logic pertaining to that one thing is contained in that single class.

### Open–closed

Interfaces have been designed in the gameplay logic, specifying the exact methods the game needs to be able to call on instances it's given.
The implementation of these classes is open for modification. See also: [Adapter pattern](#adapter-pattern) and [Strategy pattern](#strategy-pattern) above.

### Liskov principle

Class inheritance has not been made use of much.

### Interface segregation

The [GameContract](app/Game/Contracts/GameContract.php), 
[ConfigurationContract](app/Game/Contracts/ConfigurationContract.php)
and [SubmarineRepositoryContract](app/Game/Contracts/SubmarineRepositoryContract.php)
could have been designed as one big contract,
since a game will have a configuration, and it should be possible to retrieve and update submarines in the game.
To satisfy the interface segregation principle, they were made into separate contracts.

Some parts of the code might only need the methods that fetch submarines, while another part might only need to get configuration details.
With smaller contracts, the provided classes don't necessarily need to implement all the functionality at once, but only the required functionality,
reducing the need to implement unused methods. It also helps with the single responsibility principle.

### Dependency inversion

The backend code is roughly made up of two modules: the *web server*, and the *game logic*.
Both modules depend on each other; the game logic needs to get user input from HTTP requests, and needs to know the game state from the database,
while the web server needs game logic to be applied, and to be able to return information about the game back to the user.

The interaction between the game and the web framework has been made abstract, so that the game logic does not need to rely on low-level framework specifics.
The game namespace defines [contracts](app/Game/Contracts) for the web framework to implement, and [data objects](app/Game/Data) for the web framework to pass onto and expect back from its methods.
The game module code just needs to know how to deal with these contracts and data objects.
The web framework only needs to implement the contracts and provide information in the form of the given data objects.
In this way the web framework and game logic modules are not dependent on each other directly; they both depend on an abstract layer which defines possible interactions between the two.
See also: [Adapter pattern](#adapter-pattern).

## Tests

*TODO*

## Code style

*TODO*

## Algorithms

*TODO*
