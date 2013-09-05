var mayday = mayday || {};

(function (mayday, $, _) {

    var ProblemModel = Backbone.Model.extend({});
    var ProblemListModel = Backbone.Collection.extend({model: ProblemModel});

    var ProblemView = Backbone.View.extend({
        tagName: 'li',

        templates: {
            'new': _.template('<h3><%= owner.username %></h3><p><%= description %></p><button type"button">Handle</button>'),
            'handled': _.template('<h3><%= owner.username %></h3><p><%= description %></p><button type"button">Cancel</button><button type"button">Reward</button>')
        },

        events: {
            'click .btn-handle':  'handle',
            'click .btn-resolve': 'resolve',
            'click .btn-cancel':  'cancel'
        },

        initialize: function () {
            this.listenTo(this.model, 'change',  this.render);
            this.listenTo(this.model, 'destroy', this.remove);
        },

        render: function () {
            var status = this.model.get('status');
            if (this.templates[status]) this.$el.html(this.templates[status](this.model.attributes));
            else this.$el.html('');
            return this;
        }
    });

    var ProblemListView = Backbone.View.extend({
        initialize: function () {
            this.listenTo(this.model, 'add',   this.add);
            this.listenTo(this.model, 'all',   this.render);
        },

        add: function(problem) {
            //var view = new ProblemView({model: problem});
            //this.$el.append(view.render().el);
        },
        render: function() {
            this.$el.html('');
            this.model.each(function(problem) {
                var view = new ProblemView({model: problem});
                this.$el.append(view.render().el);
            }, this);
        }
    });

    var Problems = function (container, data) {
        this.model = new ProblemListModel(data);
        this.view = new ProblemListView({model: this.model, el: container});
    };

    Problems.prototype = {
        render: function () {
            this.view.render();
            return this;
        },

        listen: function (socket) {
            socket.register('problem.create',   function (data) { this.add(data); });
            socket.register('problem.handled',  function (data) { this.update(data); });
            socket.register('problem.resolved', function (data) { this.remove(data.id); });
            socket.register('problem.canceled', function (data) { this.remove(data.id); });
            return this;
        },

        add: function (problem) {
            this.model.add(problem);
            return this;
        },

        update: function (problem) {
            this.model.find(problem.id).set(problem);
            this.view.render();
            return this;
        },

        remove: function (id) {
            this.model.remove(this.model.findWhere({id: id}));
            this.view.render();
            return this;
        }
    };

    mayday.Problems = Problems;

})(mayday, $, _);
