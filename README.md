# Deeplomacy

A game about friendship and betrayal deep under the surface of the oceans.

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
    - `/Game` - Contains the high level logic for the game itself, decoupled from our framework.
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
