Learning Backbone
=================

Initial commit was made over the weekend. Everything else was my further experiments.
New stuff I've learned:
- PHP: Autoloader, View handling (MVC), RESTful handling
- Backbone.js: the whole framework (new nothing about it)

## Stories
- As an admin I can add users. A user has a name
- As an admin I can delete users
- As an admin I can assign users to a group they aren’t already part of
- As an admin I can remove users from a group
- As an admin I can create groups
- As an admin I can delete groups when they no longer have members

## Preface
- UI is based on Bootstrap
- All CSS class that are used in JavaScript must be prefixed with 'js'
- Create file watcher for /assets/css/application.less (to render CSS)
- Requests are handled in this manner: any-root-path/controller/action[/var/value/var2/value2/]
- Edit user name by clicking on it

## TODO
- Add subview/model/collection for adding/removing user from a group
- Create RESTful handling in application wide perspective
- Learn Backbone routers and implement tabs in dynamic way (without reloading page)
- Implement Groups part
- Implement PHP Less parser (removing the need to setup development environment)
- Optimize writing to DB (only at the end of application)
- Debug: if users list is empty creating new ones only the first View is rendered. For other to appear needs page reload. Data is successfully send and saved.
- Add blur action for name editing (alternative saving to clicking "enter")
