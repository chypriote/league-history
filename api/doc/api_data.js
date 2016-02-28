define({ "api": [
  {
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "varname1",
            "description": "<p>No type.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "varname2",
            "description": "<p>With type.</p>"
          }
        ]
      }
    },
    "type": "",
    "url": "",
    "version": "0.0.0",
    "filename": "./doc/main.js",
    "group": "E__Workspace_league_doc_main_js",
    "groupTitle": "E__Workspace_league_doc_main_js",
    "name": ""
  },
  {
    "type": "get",
    "url": "/champions",
    "title": "Get a list of all champions",
    "name": "GetChampions",
    "version": "1.0.0",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Array",
            "optional": false,
            "field": "champions",
            "description": "<p>List of champions</p>"
          }
        ]
      }
    },
    "filename": "./routes/champions.php",
    "group": "E__Workspace_league_routes_champions_php",
    "groupTitle": "E__Workspace_league_routes_champions_php"
  }
] });