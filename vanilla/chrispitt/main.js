var API = {
  "reset" : function() {
    return $.ajax({
      "url"  : "/api.php",
      "data" : {
        "action" : "reset"
      },
      "success" : function(data) {
        $.event.trigger({
          "type"     : "reset",
          "response" : data
        });
      }
    });
  },
  "list" : function() {
    return $.ajax({
      "url"  : "/api.php",
      "data" : {
        "action" : "list"
      },
      "success" : function(data) {
        $.event.trigger({
          "type"     : "listed",
          "response" : data
        });
      }
    });
  },
  "add" : function(description) {
    return $.ajax({
      "url"  : "/api.php",
      "data" : {
        "action"      : "add",
        "description" : description
      },
      "success" : function(data) {
        $.event.trigger({
          "type"     : "added",
          "response" : data
        });
      }
    });
  },
  "update" : function(id, description) {
    return $.ajax({
      "url"  : "/api.php",
      "data" : {
        "action"      : "update",
        "id"          : id,
        "description" : description
      },
      "success" : function(data) {
        $.event.trigger({
          "type"     : "updated",
          "response" : data
        });
      }
    });
  },
  "done" : function(id) {
    return $.ajax({
      "url"  : "/api.php",
      "data" : {
        "action" : "done",
        "id"     : id
      },
      "success" : function(data) {
        $.event.trigger({
          "type"     : "done",
          "response" : data
        });
      }
    });
  },
  "delete" : function(id) {
    return $.ajax({
      "url"  : "/api.php",
      "data" : {
        "action" : "delete",
        "id"     : id
      },
      "success" : function(data) {
        $.event.trigger({
          "type"     : "deleted",
          "response" : data
        });
      }
    });
  }
};

var InputComponent = React.createClass({
  "getInitialState" : function() {
    return {
      "description" : ""
    };
  },
  "componentDidMount" : function() {
    $(document).on("reset added", (function(e) {
      this.setState({
        "description" : ""
      });
    }).bind(this));
  },
  "handleChange" : function(e) {
    this.setState({
      "description" : e.target.value
    });
  },
  "handleKeyUp" : function(e) {
    if (e.key === "Enter") {
      if (this.state.description === "/reset") {
        return API.reset();
      }

      API.add(this.state.description);
    }
  },
  "render" : function() {
    return React.DOM.div({
      "className" : "task add",
      "children"  : [
        React.DOM.input({
          "type"      : "text",
          "className" : "description",
          "onKeyUp"   : this.handleKeyUp,
          "onChange"  : this.handleChange,
          "value"     : this.state.description
        })
      ]
    })
  }
});

var TaskComponent = React.createClass({
  "getInitialState" : function() {
    return {
      "description" : this.props.description
    };
  },
  "handleChange" : function(e) {
    this.setState({
      "description" : e.target.value
    });
  },
  "handleKeyUp" : function(e) {
    API.update(this.props.id, this.state.description);
  },
  "handleDone" : function(e) {
    API.done(this.props.id);
  },
  "handleDelete" : function(e) {
    API.delete(this.props.id);
  },
  "render" : function() {
    return React.DOM.div({
      "className" : "task" + (this.props.done === "1" ? " done" : ""),
      "children"  : [
        React.DOM.input({
          "type"      : "text",
          "className" : "description",
          "value"     : this.state.description,
          "onChange"  : this.handleChange,
          "onKeyUp"   : this.handleKeyUp
        }),
        React.DOM.i({
          "className" : "glyphicon glyphicon-ok",
          "onClick"   : this.handleDone
        }),
        React.DOM.i({
          "className" : "glyphicon glyphicon-trash",
          "onClick"   : this.handleDelete
        })
      ]
    });
  }
});

var ListComponent = React.createClass({
  "getInitialState" : function() {
    return {
      "tasks" : this.props.tasks
    };
  },
  "componentDidMount" : function() {
    $(document).on("reset added updated done deleted", (function(e) {
      API.list();
    }).bind(this));

    $(document).on("listed", (function(e) {
      this.setState({
        "tasks" : e.response.tasks
      });
    }).bind(this));
  },
  "render" : function() {
    var taskComponents = [
      InputComponent()
    ];

    for (var i = 0; i < this.state.tasks.length; i++) {
      var task = this.state.tasks[i];

      taskComponents.push(TaskComponent({
        "id"          : task.id,
        "description" : task.description,
        "done"        : task.done,
        "key"         : task.id
      }));
    }

    return React.DOM.div({
      "children" : taskComponents
    });
  }
});

React.renderComponent(
  ListComponent({
    "tasks" : TASKS
  }),
  document.querySelector(".list")
);
