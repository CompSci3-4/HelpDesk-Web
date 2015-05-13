define({ "api": [
  {
    "type": "post",
    "url": "/login.php",
    "title": "Login",
    "name": "Login",
    "group": "Login",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "user",
            "description": "<p>the username of the user you want to log in as.</p> "
          },
          {
            "group": "Parameter",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "password",
            "description": "<p>the user's password.</p> "
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>Cookie</p> ",
            "optional": false,
            "field": "HelpdeskID",
            "description": "<p>Session cookie to be used when accessing the rest of the API.</p> "
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "IncorrectUserOrPassword",
            "description": "<p>Username or password is incorrect and/or not supplied.</p> "
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "api/login.php",
    "groupTitle": "Login"
  },
  {
    "type": "delete",
    "url": "/tickets.php?id=:id",
    "title": "Delete a Ticket",
    "name": "DeleteTicket",
    "group": "Tickets",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>the Ticket's ID number.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "title",
            "description": "<p>the Ticket's title.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "description",
            "description": "<p>the Ticket's description.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "date",
            "description": "<p>the date the Ticket was created.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object</p> ",
            "optional": false,
            "field": "user",
            "description": "<p>the user who created the ticket. WARNING: User API is not finished yet, so this field should be ignored.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object</p> ",
            "optional": false,
            "field": "consultant",
            "description": "<p>the user who consults for the ticket. WARNING: User API is not finished yet, so this field should be ignored.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object</p> ",
            "optional": false,
            "field": "manager",
            "description": "<p>the user who manages the ticket. WARNING: User API is not finished yet, so this field should be ignored.</p> "
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "MissingTicketID",
            "description": "<p>id parameter not supplied.</p> "
          },
          {
            "group": "Error 4xx",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "NoDeletionRight",
            "description": "<p>User is not allowed to delete requested ticket.</p> "
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "api/tickets.php",
    "groupTitle": "Tickets"
  },
  {
    "type": "get",
    "url": "/tickets.php?id=:id",
    "title": "Get Ticket",
    "name": "GetTicket",
    "group": "Tickets",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>the Ticket's ID number.</p> "
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>the Ticket's ID number.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "title",
            "description": "<p>the Ticket's title.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "description",
            "description": "<p>the Ticket's description.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "date",
            "description": "<p>the date the Ticket was created.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object</p> ",
            "optional": false,
            "field": "user",
            "description": "<p>the user who created the ticket. Check the User API for listing of fields.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object</p> ",
            "optional": false,
            "field": "consultant",
            "description": "<p>the user who consults for the ticket. Check the User API for listing of fields.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object</p> ",
            "optional": false,
            "field": "manager",
            "description": "<p>the user who manages the ticket. Check the User API for listing of fields.</p> "
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "InvalidSessionCookie",
            "description": "<p>Session cookie either does not exist or is expired.</p> "
          },
          {
            "group": "Error 4xx",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "InvalidTicketID",
            "description": "<p>Ticket does not exist.</p> "
          },
          {
            "group": "Error 4xx",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "NoAccessRight",
            "description": "<p>User is not allowed to access requested ticket.</p> "
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "api/tickets.php",
    "groupTitle": "Tickets"
  },
  {
    "type": "get",
    "url": "/tickets.php",
    "title": "List Tickets",
    "name": "GetTickets",
    "group": "Tickets",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>Object[]</p> ",
            "optional": false,
            "field": "personal",
            "description": "<p>Tickets created by the user.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object[]</p> ",
            "optional": false,
            "field": "consultantFor",
            "description": "<p>Tickets consulted for by the user.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object[]</p> ",
            "optional": false,
            "field": "managerFor",
            "description": "<p>Tickets managed by the user.</p> "
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "InvalidSessionCookie",
            "description": "<p>Session cookie either does not exist or is expired.</p> "
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "api/tickets.php",
    "groupTitle": "Tickets"
  },
  {
    "type": "patch",
    "url": "/tickets.php?id=:id",
    "title": "Edit a Ticket",
    "name": "PatchTicket",
    "group": "Tickets",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>the Ticket's ID number.</p> "
          },
          {
            "group": "Parameter",
            "type": "<p>String</p> ",
            "optional": true,
            "field": "description",
            "description": "<p>Updated description of the problem.</p> "
          },
          {
            "group": "Parameter",
            "type": "<p>String</p> ",
            "optional": true,
            "field": "consultant",
            "description": "<p>The username of the Ticket's new consultant.</p> "
          },
          {
            "group": "Parameter",
            "type": "<p>String</p> ",
            "optional": true,
            "field": "manager",
            "description": "<p>The username of the Ticket's new manager.</p> "
          },
          {
            "group": "Parameter",
            "type": "<p>Number</p> ",
            "optional": true,
            "field": "status",
            "description": "<p>The Ticket's new status code.</p> "
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>the Ticket's ID number.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "title",
            "description": "<p>the Ticket's title.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "description",
            "description": "<p>the Ticket's description.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "date",
            "description": "<p>the date the Ticket was created.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object</p> ",
            "optional": false,
            "field": "user",
            "description": "<p>the user who created the ticket. WARNING: User API is not finished yet, so this field should be ignored.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object</p> ",
            "optional": false,
            "field": "consultant",
            "description": "<p>the user who consults for the ticket. WARNING: User API is not finished yet, so this field should be ignored.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object</p> ",
            "optional": false,
            "field": "manager",
            "description": "<p>the user who manages the ticket. WARNING: User API is not finished yet, so this field should be ignored.</p> "
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "MissingTicketID",
            "description": "<p>id parameter not supplied.</p> "
          },
          {
            "group": "Error 4xx",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "NoPatchRight",
            "description": "<p>User is not allowed to edit requested ticket.</p> "
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "api/tickets.php",
    "groupTitle": "Tickets"
  },
  {
    "type": "post",
    "url": "/tickets.php?id=:id",
    "title": "Create a Ticket",
    "name": "PostTicket",
    "group": "Tickets",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "title",
            "description": "<p>Title of the new Ticket.</p> "
          },
          {
            "group": "Parameter",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "description",
            "description": "<p>Description of the problem.</p> "
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "id",
            "description": "<p>the Ticket's ID number.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "title",
            "description": "<p>the Ticket's title.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "description",
            "description": "<p>the Ticket's description.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "date",
            "description": "<p>the date the Ticket was created.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object</p> ",
            "optional": false,
            "field": "user",
            "description": "<p>the user who created the ticket. WARNING: User API is not finished yet, so this field should be ignored.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object</p> ",
            "optional": false,
            "field": "consultant",
            "description": "<p>the user who consults for the ticket. WARNING: User API is not finished yet, so this field should be ignored.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object</p> ",
            "optional": false,
            "field": "manager",
            "description": "<p>the user who manages the ticket. WARNING: User API is not finished yet, so this field should be ignored.</p> "
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "InvalidTicketID",
            "description": "<p>Ticket does not exist.</p> "
          },
          {
            "group": "Error 4xx",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "MissingTitle",
            "description": "<p>title parameter not supplied.</p> "
          },
          {
            "group": "Error 4xx",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "MissingDescription",
            "description": "<p>description parameter not supplied.</p> "
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "api/tickets.php",
    "groupTitle": "Tickets"
  },
  {
    "type": "get",
    "url": "/users.php?username=:username",
    "title": "Get User",
    "name": "GetUser",
    "group": "Users",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "username",
            "description": "<p>the user's username.</p> "
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "username",
            "description": "<p>the user's username.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "first",
            "description": "<p>the user's first name.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "last",
            "description": "<p>the user's last name.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "email",
            "description": "<p>the user's email.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "position",
            "description": "<p>the user's position (e.g. User, Admin, Consultant).</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Number</p> ",
            "optional": false,
            "field": "room",
            "description": "<p>the user's room number.</p> "
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "InvalidSessionCookie",
            "description": "<p>Session cookie either does not exist or is expired.</p> "
          },
          {
            "group": "Error 4xx",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "NoAccessRight",
            "description": "<p>User is not allowed to view requested User (only staff are allowed to view normal users).</p> "
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "api/users.php",
    "groupTitle": "Users"
  },
  {
    "type": "get",
    "url": "/users.php",
    "title": "List Users",
    "name": "GetUsers",
    "group": "Users",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>Object[]</p> ",
            "optional": false,
            "field": "users",
            "description": "<p>all Users in the database.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object[]</p> ",
            "optional": false,
            "field": "consultants",
            "description": "<p>all consultants in the database.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object[]</p> ",
            "optional": false,
            "field": "managers",
            "description": "<p>all managers in the database.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>Object[]</p> ",
            "optional": false,
            "field": "admins",
            "description": "<p>all admins in the database.</p> "
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "InvalidSessionCookie",
            "description": "<p>Session cookie either does not exist or is expired.</p> "
          },
          {
            "group": "Error 4xx",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "NoAccessRight",
            "description": "<p>User does not have permission to view all users (only staff may view all users).</p> "
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "api/users.php",
    "groupTitle": "Users"
  }
] });