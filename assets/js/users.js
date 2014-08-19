// Starting only when everything is loaded
$(function(){
    "use strict";

    // User model to store data, validate it, etc.
    var UserModel = Backbone.Model.extend({
        urlRoot: function() {
            return appUsersDataUrl;
        },

        // Default attributes of the user. It should be in sync with the backend logic
        defaults: {
            id: 0,
            name: 'No name',
            groups: {
                '1': 'Group 1',
                '2': 'Group 2'
            },
            groupsCount: 2
        }
    });

    // Collection of users, mapping to the API where data (for the model) can be retrieved and synced to
    var UsersCollections = Backbone.Collection.extend({
        // assigning user model
        model: UserModel,

        // setting the url keeping as a function for convenience if extra logic will be needed
        url: function() {
            return appUsersUrl; // API URL is set by the backend, keeping JavaScript parts future safe
        },

        // If data is retrieved in different format than plain JSON, it should be parsed
        parse: function(response) {
//            response = response.success;
            return response;
        }
    });

    // User view - everything for each user
    var UserView = Backbone.View.extend({
        // setting CSS classes for UI changes
        cssItem: 'list-group-item',
        cssActive: 'active',
        cssEditable: 'editable',
        cssHidden: 'hidden',

        // DOM tag - this should work with the parent element where it will be appended to
        tagName: 'a',

        // Backbone creates DOM element on demand, therefore, we need to add classes to render element as we need
        className: function() {
            return this.cssItem;
        },

        // Template for building user entry
        template: _.template($('#jsUserTemplate').html()),

        // template for groups
        groupsTemplate: _.template($('#jsUserGroupTemplate').html()),

        // All events for each user item
        events: {
            'click': 'toggle', // entering edit mode - showing groups
            'click .jsRemove': 'removeOnButton', // delete the user
            'click .jsName': 'editName', // edit name
            'keypress .jsName': 'updateOnEnter', // update name
            'click .jsRemoveGroup': 'removeGroup', // remove user from a group
            'click .jsAddGroup': 'addGroup' // adding a new group
        },

        // actions on item creation
        initialize: function() {
            this.listenTo(this.model, 'change', this.render);
            this.listenTo(this.model, 'destroy', this.remove);
        },

        // Expand the view
        toggle: function(e) {
            // Our item is an <a> tag and we want to prevent browser to follow it's href
            e.preventDefault();

            // if element is closed (doesn't have required class assigned)
            if (!this.$el.hasClass(this.cssActive)) {
                // opening
                this.$el.addClass(this.cssActive);
                this.$('.jsGroups').removeClass(this.cssHidden);
            } else {
                // closing edit mode to list view
                // saving the data
                this.$el.removeClass(this.cssActive);
                this.$('.jsGroups').addClass(this.cssHidden);
            }
        },

        // Closing/saving user data
        close: function() {
            var $name = this.$('.jsName');
            var value = $name.text();
            this.$('.jsName')
                .blur()
                .prop('contentEditable', false)
                .removeClass(this.cssEditable);

            if (value) {
                // saving data
                this.model.save({name: value});
            } else {
                // deleting if name is removed
                this.clear();
            }
        },

        // Editing the name
        editName: function(e) {
            // Our item is an <a> tag and we want to prevent browser to follow it's href
            e.preventDefault();
            e.stopPropagation();

            this.$('.jsName')
                .prop('contentEditable', true)
                .addClass(this.cssEditable)
                .focus();
        },

        updateOnEnter: function(e) {
            if (e.keyCode == 13) {
                this.close();
            }
        },

        removeOnButton: function(e) {
            // Our item is an <a> tag and we want to prevent browser to follow it's href
            e.preventDefault();
            e.stopPropagation();

            this.clear();
        },

        // removing item from collection and UI
        clear: function() {
            // deleting model
            this.model.destroy({
                // waiting for the server to response before moving item from UI
                wait: true,

                // server should send null or the same object
//                success: function(model, response) {},

                // handling errors
                error: function(model, response) {}
            });
        },

        // add new group to a user
        addGroup: function(e) {
            // Our item is an <a> tag and we want to prevent browser to follow it's href
            e.preventDefault();
            e.stopPropagation();

            // todo: opening group list user doesn't belong to; clicking on group name it is added to user data and saved
            alert('todo: add new group');
        },

        // Rendering each items
        render: function(event) {
            // taking item (this.$el)
            // setting the HTML of it from the defined template (this.template)
            // while giving the data values to the template (this.model.attributes or this.model.toJSON())
            this.$el
                .html(this.template(this.model.attributes))
                .attr('href', this.model.url());

            this.groups = this.$('.jsGroups');

            var groups = this.model.attributes.groups;
            _.each(groups, function(el, index, list){
                this.groups.prepend(this.groupsTemplate({id: index, name: el}));
            }, this);
            return this;
        }
    });

    // The main application view
    var UsersAppView = Backbone.View.extend({
        // Attaching the application to existing DOM element
        el: $('#jsUserApp'),

        events: {
            'keypress .jsNew': 'createOnEnter'
        },

        // Doing some work before running the application
        initialize: function() {
            // setting required listeners on user collections
            this.listenTo(users, 'add', this.addOne);
            this.listenTo(users, 'reset', this.addAll);
            this.listenTo(users, 'all', this.render);

            // setting up an object for new item creation
            this.newItem = this.$('.jsNew');

            // firing to get users data from the server
            users.fetch();
        },

        // handling the action for adding a new user to the UI
        addOne: function(UserModel) {
            var view = new UserView({model: UserModel});
            this.$('#jsUsersList').append(view.render().el);
        },

        // adding all users at once
        addAll: function() {
            // going through users collection and adding to the UI one by one
            users.each(this.addOne, this);
        },

        createOnEnter: function(e) {
            // do nothing if key pressed isn't "enter"
            if (e.keyCode != 13) return;
            // do nothing if no value is entered
            var newName = this.newItem.val();
            if (!newName) return;

            // adding new users and saving to the server
            users.create({name: newName});

            // reseting the input field
            this.newItem.val('');
        },

        // things that needs to be rendered specifically for the whole app
        render: function() {

        }
    });

    // creating the actual collections of users
    var users = new UsersCollections();

    // starting the application
    var UsersApp = new UsersAppView();
});
