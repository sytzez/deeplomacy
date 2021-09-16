# Deeplomacy

A game about friendship and betrayal deep under the surface of the ocean.

## Getting started

*TODO: write getting started guide*

## Game rules

Each player controls a submarine on the game grid. A player can only see around them up until a certain distance.
*Action points* are distributed regularly to all players, which they can use to perform actions.

### Actions

- *Moving* - Moves the submarine to another cell on the grid. Longer distances cost more action points. 
- *Attacking* - Targets another submarine, a probabilistic calculation is made to determine whether the target lives or dies. 
  The range is unlimited, as long as the target is visible to the attacker.
- *Donating action points* - Transfers a chosen amount of action points to another submarine.
- *Sharing sonar* - Permanently grants another submarine access to the player's own field of view.

The strategy in the game lies in deciding whether to attack or befriend other players. 
There is much advantage in playing within a group over playing alone, but eventually there can only be one survivor to win the game.

## File structure

Some noteworthy  directories.

- `/app` - The backend Laravel project
    - `/Adapters` - These classes represent the layer adapting our Laravel models to their Game contracts.
    - `/Factories` - They turn HTTP requests into objects we need for the game.
    - `/Game` - Contains the high level logic for the game itself, agnostic of our framework.
        - `/Actions` - Actions a player can take to mutate the state of the game.
        - `/Contracts` - These contracts (interfaces) should be implemented by the lower level framework to work with the game logic.
        - `/Data` - Immutable data objects representing things inside the game.
        - `/Services` - These services perform the hard business logic of the game.
        - `/Validators` - The validators check whether certain actions are valid in the game.
        - `/Strategies` - Currently only used for placing new submarines in the game. Various placement strategies could be chosen.
    - `/Http` - Our controllers, form requests, view composers etc.
    - `/Models` - The models represent the content of our database, standard Laravel stuff.
    - `/Jobs` - Stuff that has to be done regularly, like distributing action points to all players
- `/resources`
    - `/angular` - The frontend Angular project.
        - *TODO*

## Design patterns utilized

### Adapter pattern

To keep the gameplay code (everything within `/app/Game`) agnostic of framework-specific classes and practices,
the game namespace provides contracts to interface with the framework in a useful way.

Adapter classes have been implemented for each Laravel model to make them work in a way that satisfies their corresponding game contract.
For example, the game specifies a `SubmarineContract` with all the methods it needs to be able to call on a submarine.
The `SubmarineAdapter` class then wraps around the `Submarine` model class, and implements the contract's methods using Laravel-style operations, such as magic properties.

This way the Laravel models don't need to know about what the game needs, and the game doesn't need to know the specifics of Laravel models.

### Strategy pattern

Some details of the game could be implemented in various different ways, and these ways could be changed and switched back-and-forth over time.
However, we don't want the code that relies on these things happen to suffer instability from these changes, we only want to edit the relevant class.

An example of this is the placement of new submarines on the game grid. There are many different ways, simple and complex, to calculate the ideal position at which a new player should enter the game.
The rest of the game code couldn't care less how this is done, it just needs the submarine to be placed.

To facilitate this separation, a `PlacementStrategyContract` interface is used by the rest of the game logic to do this placement.
A specific placement strategy class instance implementing this contract is passed to the `JoinGameAction->do` method,
leaving the caller of the method to decide what strategy will be used.

### Action pattern

The easiest way to understand the rules of a game, especially a (semi) turn based one, is in terms of actions performed by the players, which mutate the state of the game.

Using the action pattern with a single public `do` method makes it very clear to the reader what these classes will do.
Examples: `JoinGameAction`, `AttackSubmarineAction`, `GiveActionPointsAction`.

The idea is similar to the Controller pattern, as the classes themselves don't contain much logic.
The action classes usually only call a validation method and a service method to facilitate the action.
Instead of taking an HTTP request, they take the intended move of the game player, and instead of returning a response, they mutate the state of the game.

### Factory pattern

The server receives HTTP requests, but the game wants to get information about what to do in a very specific way, using action data objects.
Factories contain the code to take the HTTP request and output the correct action data, so that neither our HTTP controllers nor our game action classes have to bother with this tranformation.

### Immutable objects

The gameplay code provides some immutable data classes to represent things that are part of the game, like action points, positions, action data, and more.
Being immutable makes the code using these classes less prone to bugs. If they were mutable, one part of the code could make changes to an instance, while another part of the code could expect the instance to remain the same.
With immutable objects you can pass the instance into the method of another class, even through an interface without being aware of the implementation of the method,
and be assured the instance will not be modified.
