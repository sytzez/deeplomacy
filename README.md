# Deeplomacy

## Game rules

## Getting started

## File structure

Some notable  directories

- `/app`
    - `/Adapters` - These classes represent the layer adapting our Laravel models to their Game contracts
    - `/Game` - Contains the high level logic for the game itself, decoupled from our framework
        - `/Actions` - These perform actions an agent can perform in the game
        - `/Contracts` - These contracts (interfaces) should be implemented by the lower level framework to work with the game logic
        - `/Data` - Immutable data objects that are used by the game logic
        - `/Services` - These services perform the hard business logic of the game
        - `/Validators` - The validators check whether certain actions are valid in the game
    - `/Models` - The models represent the content of our database, standard Laravel stuff
