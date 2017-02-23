define({ "api": [
  {
    "type": "GET",
    "url": "/Areas/:date",
    "title": "",
    "group": "Areas",
    "description": "<p>Retorna Todos los registros de Areas, si se provee :date se filtraran los resultados modificados a partir de :date</p>",
    "permission": [
      {
        "name": "user",
        "title": "Cualquier Usuario",
        "description": "<p>Requiere User y Password validos definidos en Header</p>"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Clave Unica de Acceso RFC2045-MIME (Base64).</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Header:",
          "content": "{\"Authorization\":\"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3\"}",
          "type": "Json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Date",
            "optional": true,
            "field": "date",
            "description": "<p>Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong></p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "401",
            "description": "<p>Usuario o Contraseña Invalidos</p>"
          },
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "404",
            "description": "<p>LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Error 401:",
          "content": "{\"ERROR\":\"USARIO/CONTRASEÑA INVALIDOS\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...\"}",
          "type": "Json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Json",
            "optional": false,
            "field": "200",
            "description": "<p>Arreglo de Objetos de tipo AREA</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Respuesta:",
          "content": "{\"AREAS\":[{\"ID_AREA\":\"516\",\"DESCRIPCION\":\"EL RESPALDO,(VR)  \",\"CODAREA\":\"05107R00209\",\"CODPOSTAL\":\"\",\"DPTO\":\"05\",\"MUNICIPIO\":\"107\",\"ZONA\":\"R\",\"NIVEL4\":\"00\",\"CODIGO\":\"209\",\"ESTADO\":\"A\",\"ORDEN\":\"516\"},{...}]}",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "Areas",
    "name": "GetAreasDate"
  },
  {
    "type": "GET",
    "url": "/CIE10",
    "title": "",
    "group": "CIE10",
    "description": "<p>Retorna La Lista de CIE10 Completa</p>",
    "permission": [
      {
        "name": "user",
        "title": "Cualquier Usuario",
        "description": "<p>Requiere User y Password validos definidos en Header</p>"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Clave Unica de Acceso RFC2045-MIME (Base64).</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Header:",
          "content": "{\"Authorization\":\"Basic eWVubnkubmF2YXJybzowZTljMzA1YmUyMDg2ZGRkZGU3NDM3MzUxMDVhY2ViNQ==\"}",
          "type": "Json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "401",
            "description": "<p>Usuario o Contraseña Invalidos</p>"
          },
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "404",
            "description": "<p>LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Error 401:",
          "content": "{\"ERROR\":\"USARIO/CONTRASEÑA INVALIDOS\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...\"}",
          "type": "Json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Json",
            "optional": false,
            "field": "200",
            "description": "<p>Arreglo de Objetos de tipo CIE10</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Respuesta:",
          "content": "{\"CIE10\":[{\"ID\":\"1\",\"CODIGO\":\"A000\",\"DESCRIPCION\":\"COLERA DEBIDO A VIBRIO CHOLERAE O1, BIOTIPO CHOLERAE\",\"CLASE\":\"\",\"ACTIVO\":\"0\",\"TIPO\":\"F\"},{...}]}",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "CIE10",
    "name": "GetCie10"
  },
  {
    "type": "GET",
    "url": "/Departamentos/:date",
    "title": "",
    "group": "Departamentos",
    "description": "<p>Retorna Todos los registros de Departamentos, si se provee :date se filtraran los resultados modificados a partir de :date</p>",
    "permission": [
      {
        "name": "user",
        "title": "Cualquier Usuario",
        "description": "<p>Requiere User y Password validos definidos en Header</p>"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Clave Unica de Acceso RFC2045-MIME (Base64).</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Header:",
          "content": "{\"Authorization\":\"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3\"}",
          "type": "Json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Date",
            "optional": true,
            "field": "date",
            "description": "<p>Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong></p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "401",
            "description": "<p>Usuario o Contraseña Invalidos</p>"
          },
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "404",
            "description": "<p>LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Error 401:",
          "content": "{\"ERROR\":\"USARIO/CONTRASEÑA INVALIDOS\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...\"}",
          "type": "Json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Json",
            "optional": false,
            "field": "200",
            "description": "<p>Arreglo de Objetos de tipo DEPARTAMENTO</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Respuesta:",
          "content": "{\"DEPARTAMENTOS\":[{\"ID\" : \"2\",\"NOMBRE\" : \"ANTIOQUIA\",\"PAIS\" : \"57\",\"CODIGO\" : \"05\",\"ACTIVO\" : \"0\"},{...}]}",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "Departamentos",
    "name": "GetDepartamentosDate"
  },
  {
    "type": "POST",
    "url": "/HistoriaClinica/medico",
    "title": "",
    "group": "Historia_Clinica",
    "description": "<p>Guarda una o varias historias clinicas y retorna los ids correspondientes</p>",
    "permission": [
      {
        "name": "specific_user",
        "title": "Usuario Especifico",
        "description": "<p>Requiere User y Password validos definidos en Header. Tenga en cuenta que se entregaran unicamente los registros relacionados con el usuario que realiza la peticion</p>"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Json",
            "optional": false,
            "field": "File",
            "description": "<p>Archivo json que contiene todas las respuestas y categorias disponibles para una Historia Clinica</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "{\"2\":{\"ACOMPAÑANTES\":[[[\"37\",\"10\"],[\"38\",\"AGUDELO\"],[\"39\",\"GOMEZ\"],[\"40\",\"CARLOS\"],[\"41\",\"AUGUSTO\"],[\"42\",\"CC\"],[\"43\",\"1010102020\"],[\"44\",\"30\"],[\"45\",\"ESS024\"],[\"46\",\"1\"],[\"47\",\"CALLE FALSA 123\"],[\"48\",\"1\"],[\"49\",\"4445263\"],[\"50\",\"3207070803\"],[\"52\",\"1\"]],[[\"37\",\"10\"],[\"38\",\"AGUDELO\"],[\"39\",\"GOMEZ\"],[\"40\",\"ERNEY\"],[\"41\",\"FERNEY\"],[\"42\",\"CC\"],[\"43\",\"1010102020\"],[\"44\",\"30\"],[\"45\",\"ESS024\"],[\"46\",\"1\"],[\"47\",\"CALLE FALSA 123\"],[\"48\",\"1\"],[\"49\",\"4445263\"],[\"50\",\"3207070803\"],[\"52\",\"1\"]]],\"ANTECEDENTES_MEDICAMENTOS\":[[[\"159\",\"1\"],[\"160\",\"1\"],[\"161\",\"1\"],[\"162\",\"1\"],[\"163\",\"1\"],[\"164\",\"1\"],[\"165\",\"10:30\"],[\"166\",\"1\"]],[[\"159\",\"1\"],[\"160\",\"1\"],[\"161\",\"1\"],[\"162\",\"1\"],[\"163\",\"1\"],[\"164\",\"1\"],[\"165\",\"10:30\"],[\"166\",\"1\"]]],\"ANTECEDENTES_PERSONALES\":[[[\"98\",\"1\"],[\"99\",\"R90\"],[\"100\",\"1\"],[\"101\",\"2015-08-20\"],[\"102\",\"1\"],[\"103\",\"35\"],[\"104\",\"2015-09-30\"]],[[\"105\",\"1\"],[\"106\",\"1\"],[\"107\",\"1\"],[\"108\",\"2015-09-30\"]],[[\"109\",\"1\"],[\"110\",\"COCA\"],[\"111\",\"1\"],[\"112\",\"20\"],[\"113\",\"2015\"],[\"114\",\"1\"],[\"115\",\"30\"],[\"116\",\"2\"]]],\"ANTECEDENTES_FAMILIARES\":[[[\"76\",\"1\"],[\"77\",\"1\"],[\"78\",\"1\"],[\"79\",\"1\"],[\"80\",\"2\"],[\"81\",\"0\"],[\"82\",\"0\"],[\"83\",\"1\"],[\"84\",\"1\"],[\"85\",\"3\"]],[[\"76\",\"2\"],[\"77\",\"1\"],[\"78\",\"1\"],[\"79\",\"1\"],[\"80\",\"2\"],[\"81\",\"0\"],[\"82\",\"0\"],[\"83\",\"1\"],[\"84\",\"1\"],[\"85\",\"3\"]],[[\"76\",\"3\"],[\"77\",\"1\"],[\"78\",\"1\"],[\"79\",\"1\"],[\"80\",\"2\"],[\"81\",\"0\"],[\"82\",\"0\"],[\"83\",\"1\"],[\"84\",\"1\"],[\"85\",\"3\"]]],\"ANTECEDENTES_FALLECIDOS\":[[[\"94\",\"1\"],[\"95\",\"0\"],[\"96\",\"1\"],[\"97\",\"2015-08-20\"]],[[\"94\",\"2\"],[\"95\",\"0\"],[\"96\",\"1\"],[\"97\",\"2015-08-20\"]],[[\"94\",\"3\"],[\"95\",\"0\"],[\"96\",\"1\"],[\"97\",\"2015-08-20\"]]],\"CITAS\":[[[\"289\",\"1\"],[\"290\",\"2016-03-15\"],[\"291\",\"URGENTE\"]],[[\"289\",\"2\"],[\"290\",\"2016-04-15\"],[\"291\",\"Preguntar por ...\"]]],\"DIAGNOSTICOS\":[[[\"257\",\"E14\"],[\"258\",\"1\"]],[[\"282\",\"1\"],[\"283\",\"DDD\"]],[[\"284\",\"2\"],[\"285\",\"AAA\"]],[[\"286\",\"3\"],[\"287\",\"EEE\"]]],\"INTERCONSULTA\":[[[\"280\",\"1\"],[\"281\",\"4\"]],[[\"280\",\"2\"],[\"281\",\"5\"]],[[\"280\",\"3\"],[\"281\",\"6\"]]],\"LABORATORIOS\":[[[\"213\",\"1\"],[\"214\",\"1\"],[\"215\",\"1\"],[\"216\",\"2015-10-18\"],[\"217\",\"1\"],[\"218\",\"42195\"],[\"219\",\"OBSERVACION\"]],[[\"213\",\"1\"],[\"214\",\"1\"],[\"215\",\"1\"],[\"216\",\"2015-10-18\"],[\"217\",\"1\"],[\"218\",\"42195\"],[\"219\",\"OBSERVACION\"]]],\"OTROS_LABORATORIOS\":[[[\"220\",\"1\"],[\"221\",\"2\"],[\"222\",\"2\"],[\"223\",\"2015-10-30\"],[\"224\",\"OTRA OBSERVACION\"]],[[\"220\",\"1\"],[\"221\",\"2\"],[\"222\",\"2\"],[\"223\",\"2015-10-30\"],[\"224\",\"OTRA OBSERVACION\"]]],\"PARACLINICOS\":[[[\"259\",\"1\"],[\"260\",\"2\"],[\"261\",\"2015-06-07\"]],[[\"259\",\"1\"],[\"260\",\"3\"],[\"261\",\"2015-06-07\"]],[[\"259\",\"0\"],[\"260\",\"3\"],[\"261\",\"2015-06-07\"]]],\"PLAN_TERAPEUTICO\":[[[\"262\",\"1\"],[\"263\",\"1\"],[\"264\",\"16\"],[\"265\",\"50\"],[\"266\",\"3\"],[\"267\",\"4\"]],[[\"262\",\"2\"],[\"263\",\"2\"],[\"264\",\"13\"],[\"265\",\"25\"],[\"266\",\"4\"],[\"267\",\"4\"]]],\"RESPUESTAS\":[[\"201\",\"1\"],[\"202\",\"1\"],[\"203\",\"1\"],[\"204\",\"1\"],[\"205\",\"1\"],[\"206\",\"1\"],[\"207\",\"1\"],[\"208\",\"1\"],[\"209\",\"1\"],[\"210\",\"1\"],[\"211\",\"1\"],[\"212\",\"1\"],[\"182\",\"90\"],[\"183\",\"60\"],[\"184\",\"110\"],[\"185\",\"80\"],[\"186\",\"37\"],[\"187\",\"65\"],[\"188\",\"150\"],[\"189\",\"28,8\"],[\"190\",\"O\"],[\"191\",\"70\"],[\"192\",\"75\"],[\"193\",\"90\"],[\"194\",\"1\"],[\"195\",\"1\"],[\"196\",\"1\"],[\"197\",\"1\"],[\"198\",\"1\"],[\"199\",\"1\"],[\"200\",\"1\"],[\"167\",\"1\"],[\"168\",\"1\"],[\"169\",\"1\"],[\"170\",\"1\"],[\"171\",\"1\"],[\"172\",\"1\"],[\"173\",\"1\"],[\"174\",\"1\"],[\"175\",\"1\"],[\"176\",\"1\"],[\"177\",\"1\"],[\"178\",\"1\"],[\"179\",\"1\"],[\"180\",\"1\"],[\"181\",\"1\"],[\"117\",\"1\"],[\"118\",\"10\"],[\"119\",\"10\"],[\"120\",\"1\"],[\"121\",\"20\"],[\"122\",\"10\"],[\"123\",\"1\"],[\"124\",\"1\"],[\"125\",\"1\"],[\"126\",\"1\"],[\"127\",\"1\"],[\"128\",\"1\"],[\"129\",\"1\"],[\"130\",\"1\"],[\"131\",\"1\"],[\"132\",\"1\"],[\"133\",\"1\"],[\"134\",\"1\"],[\"135\",\"2014-12-31\"],[\"136\",\"1\"],[\"137\",\"1\"],[\"138\",\"1\"],[\"139\",\"1\"],[\"140\",\"1\"],[\"141\",\"2015-08-30\"],[\"142\",\"10\"],[\"143\",\"1\"],[\"144\",\"1\"],[\"145\",\"5\"],[\"146\",\"1\"],[\"147\",\"2015-06-15\"],[\"148\",\"1\"],[\"149\",\"1\"],[\"150\",\"2015-07-10\"],[\"151\",\"1\"],[\"152\",\"1\"],[\"153\",\"2015-08-10\"],[\"154\",\"1\"],[\"155\",\"1\"],[\"156\",\"2015-08-10\"],[\"157\",\"1\"],[\"158\",\"1\"],[\"94\",\"1\"],[\"95\",\"0\"],[\"96\",\"1\"],[\"97\",\"2015-08-20\"],[\"55\",\"1\"],[\"56\",\"1\"],[\"57\",\"1\"],[\"58\",\"1\"],[\"59\",\"1\"],[\"60\",\"1\"],[\"61\",\"1\"],[\"62\",\"1\"],[\"63\",\"1\"],[\"64\",\"1\"],[\"65\",\"1\"],[\"66\",\"1\"],[\"67\",\"1\"],[\"68\",\"1\"],[\"69\",\"1\"],[\"70\",\"1\"],[\"71\",\"1\"],[\"72\",\"1\"],[\"73\",\"1\"],[\"74\",\"1\"],[\"75\",\"OTRO SINTOMA\"],[\"86\",\"1\"],[\"87\",\"1\"],[\"88\",\"1\"],[\"89\",\"1\"],[\"90\",\"2\"],[\"91\",\"0\"],[\"92\",\"0\"],[\"93\",\"1\"],[\"2\",\"RUTA 1\"],[\"3\",\"L\"],[\"4\",\"2015-10-31\"],[\"5\",\"2017-01-13\"],[\"6\",\"1\"],[\"7\",\"L\"],[\"8\",\"05\"],[\"9\",\"250\"],[\"10\",\"U\"],[\"11\",\"1\"],[\"12\",\"REINA\"],[\"13\",\"DE BARCENAS\"],[\"14\",\"CECILIA\"],[\"16\",\"CC\"],[\"17\",\"37829879\"],[\"18\",\"F\"],[\"19\",\"F\"],[\"20\",\"1\"],[\"21\",\"1984-08-12\"],[\"22\",\"33\"],[\"23\",\"ESS024\"],[\"24\",\"S\"],[\"25\",\"S\"],[\"26\",\"1\"],[\"27\",\"1\"],[\"28\",\"1\"],[\"29\",\"4\"],[\"30\",\"9999\"],[\"31\",\"1\"],[\"32\",\"CALLE FALSA 123\"],[\"33\",\"10\"],[\"34\",\"4444444\"],[\"35\",\"3101010100\"],[\"36\",\"3040404004\"],[\"53\",\"UN DOLOR\"],[\"54\",\"UNA GRAN ENFERMEDAD\"],[\"293\",\"2017-01-16-12.21.34.000000\"],[\"294\",\"1\"],[\"53\",\"UN DOLOR\"],[\"54\",\"UNA GRAN ENFERMEDAD\"]],\"TEMAS\":[[[\"288\",\"1\"]],[[\"288\",\"34\"]],[[\"288\",\"25\"]],[[\"288\",\"18\"]]],\"GLUCOMETRIAS\":[[[\"244\",\"1\"],[\"245\",\"10:30\"],[\"246\",\"2017-02-20\"],[\"299\",\"1\"]],[[\"244\",\"1\"],[\"245\",\"11:30\"],[\"246\",\"2017-02-20\"],[\"299\",\"1\"]],[[\"244\",\"1\"],[\"245\",\"12:30\"],[\"246\",\"2017-02-20\"],[\"299\",\"1\"]]],\"EXAMENES\":[[[\"228\",\"1\"],[\"229\",\"2017-02-20\"],[\"230\",\"EXAMEN 1\"],[\"231\",\"I10X\"],[\"232\",\"1\"],[\"247\",\"1\"],[\"248\",\"2\"]],[[\"228\",\"2\"],[\"229\",\"2017-02-20\"],[\"230\",\"EXAMEN 2\"],[\"231\",\"E40\"],[\"232\",\"1\"],[\"247\",\"1\"],[\"248\",\"2\"]],[[\"228\",\"3\"],[\"229\",\"2017-02-20\"],[\"230\",\"EXAMEN 3\"],[\"231\",\"J40\"],[\"232\",\"1\"],[\"247\",\"1\"],[\"248\",\"2\"]]]}}",
          "type": "Json"
        }
      ]
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Clave Unica de Acceso RFC2045-MIME (Base64).</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Header:",
          "content": "{\"Authorization\":\"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3\"}",
          "type": "Json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "401",
            "description": "<p>Usuario o Contraseña Invalidos</p>"
          },
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "404",
            "description": "<p>LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Error 401:",
          "content": "{\"ERROR\":\"USARIO/CONTRASEÑA INVALIDOS\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...\"}",
          "type": "Json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Json",
            "optional": false,
            "field": "200",
            "description": "<p>Arreglo de Objetos de tipo HISTORIA_MEDICA que puede contener uno o varios IDS así como mensajes de error relacionados con la insercion de Historias Clinicas</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Respuesta:",
          "content": "{\"HISTORIA_MEDICA\":[\"8\",\"9\",{\"ERROR\":\"DESCRIPCION DEL ERROR\"}]}",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "Historia_Clinica",
    "name": "PostHistoriaclinicaMedico"
  },
  {
    "type": "GET",
    "url": "/Ips/:date",
    "title": "",
    "group": "Ips",
    "description": "<p>Retorna Todos los registros de Instituciones Prestadoras de Servicios, si se provee :date se filtraran los resultados modificados a partir de :date</p>",
    "permission": [
      {
        "name": "user",
        "title": "Cualquier Usuario",
        "description": "<p>Requiere User y Password validos definidos en Header</p>"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Clave Unica de Acceso RFC2045-MIME (Base64).</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Header:",
          "content": "{\"Authorization\":\"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3\"}",
          "type": "Json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Date",
            "optional": true,
            "field": "date",
            "description": "<p>Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong></p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "401",
            "description": "<p>Usuario o Contraseña Invalidos</p>"
          },
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "404",
            "description": "<p>LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Error 401:",
          "content": "{\"ERROR\":\"USARIO/CONTRASEÑA INVALIDOS\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...\"}",
          "type": "Json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Json",
            "optional": false,
            "field": "200",
            "description": "<p>Arreglo de Objetos de tipo IPS</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Respuesta:",
          "content": "{\"IPS\":[{\"ID\":\"1\",\"COD_INS\":\"1\",\"NIT\":\"1\",\"NOMBRE\":\"SALUDFAMILIAR IPS\",\"DIRECCION\":\"CARRERA 57 # 74 - 71\",\"PAIS\":\"57\",\"DPTO\":\"08\",\"CIUDAD\":\"001\",\"TELEFONO\":\"3588128\",\"MOVIL\":\"3162413498\",\"EMAIL\":\"rennimunoz@saludfamiliar.com.co\",\"REPRESENTANTE\":\"\",\"ACTIVO\":\"0\"},{...}]}",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "Ips",
    "name": "GetIpsDate"
  },
  {
    "type": "GET",
    "url": "/Laboratorios",
    "title": "",
    "group": "Laboratorios",
    "description": "<p>Retorna el Listado de Laboratorios</p>",
    "permission": [
      {
        "name": "user",
        "title": "Cualquier Usuario",
        "description": "<p>Requiere User y Password validos definidos en Header</p>"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Clave Unica de Acceso RFC2045-MIME (Base64).</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Header:",
          "content": "{\"Authorization\":\"Basic eWVubnkubmF2YXJybzowZTljMzA1YmUyMDg2ZGRkZGU3NDM3MzUxMDVhY2ViNQ==\"}",
          "type": "Json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "401",
            "description": "<p>Usuario o Contraseña Invalidos</p>"
          },
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "404",
            "description": "<p>LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Error 401:",
          "content": "{\"ERROR\":\"USARIO/CONTRASEÑA INVALIDOS\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...\"}",
          "type": "Json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Json",
            "optional": false,
            "field": "200",
            "description": "<p>Arreglo de Objetos de tipo LABORATORIO</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Respuesta:",
          "content": "{\"LABORATORIOS\":[{\"ID_LABORATORIO\":\"1\",\"CODIGO\":\"1\",\"DESCRIPCION\":\"LABORATORIO DE EJEMPLO\",\"VALORREF1\":\"10\",\"VALORREF2\":\"15\",\"TIPO\":\"1\",\"ORDEN\":\"1\"},{...}]}",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "Laboratorios",
    "name": "GetLaboratorios"
  },
  {
    "type": "GET",
    "url": "/ListasReferencia/:date",
    "title": "",
    "group": "Listas_Referencia",
    "description": "<p>Retorna Todos los registros de Lista de Referencia, si se provee :date se filtraran los resultados modificados a partir de :date</p>",
    "permission": [
      {
        "name": "user",
        "title": "Cualquier Usuario",
        "description": "<p>Requiere User y Password validos definidos en Header</p>"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Clave Unica de Acceso RFC2045-MIME (Base64).</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Header:",
          "content": "{\"Authorization\":\"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3\"}",
          "type": "Json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Date",
            "optional": true,
            "field": "date",
            "description": "<p>Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong></p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "401",
            "description": "<p>Usuario o Contraseña Invalidos</p>"
          },
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "404",
            "description": "<p>LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Error 401:",
          "content": "{\"ERROR\":\"USARIO/CONTRASEÑA INVALIDOS\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...\"}",
          "type": "Json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Json",
            "optional": false,
            "field": "200",
            "description": "<p>Arreglo de Objetos de tipo LISTA_REFERENCIA</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Respuesta:",
          "content": "{\"LISTAS_REFERENCIA\":[{\"ID_LISTA\":\"1\",\"PADRE\":\"\",\"DESCRIPCION\":\"Motivo Visita\",\"CODLISTA\":\"\",\"VALOR\":\"\",\"ESTADO\":\"\"},{...}]}",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "Listas_Referencia",
    "name": "GetListasreferenciaDate"
  },
  {
    "type": "GET",
    "url": "/Medicamentos",
    "title": "",
    "group": "Medicamentos",
    "description": "<p>Retorna el Listado de Medicamentos</p>",
    "permission": [
      {
        "name": "user",
        "title": "Cualquier Usuario",
        "description": "<p>Requiere User y Password validos definidos en Header</p>"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Clave Unica de Acceso RFC2045-MIME (Base64).</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Header:",
          "content": "{\"Authorization\":\"Basic eWVubnkubmF2YXJybzowZTljMzA1YmUyMDg2ZGRkZGU3NDM3MzUxMDVhY2ViNQ==\"}",
          "type": "Json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "401",
            "description": "<p>Usuario o Contraseña Invalidos</p>"
          },
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "404",
            "description": "<p>LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Error 401:",
          "content": "{\"ERROR\":\"USARIO/CONTRASEÑA INVALIDOS\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...\"}",
          "type": "Json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Json",
            "optional": false,
            "field": "200",
            "description": "<p>Arreglo de Objetos de tipo MEDICAMENTO</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Respuesta:",
          "content": "{\"MEDICAMENTOS\":[{\"ID_MEDICAMENTO\":\"1\",\"CODIGO\":\"J05AF0601\",\"DESCRIPCION\":\"ABACAVIR\",\"PRINCIPIO\":\"ABACAVIR\",\"CONCENTRACION\":\"Incluye todas las concentraciones\",\"PRESENTACION\":\"TABLETA CON O SIN RECUBRIMIENTO QUE NO MODIFIQUE LA LIBERACI\\u00d3N DEL F\\u00c1RMACO, C\\u00c1PSULA\",\"ACLARACION\":\"\",\"GRUPO\":\"\"},{...}]",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "Medicamentos",
    "name": "GetMedicamentos"
  },
  {
    "type": "GET",
    "url": "/Modulos/:date",
    "title": "",
    "group": "Modulos",
    "description": "<p>Retorna el Listado de Modulos, si se provee :date se filtraran los resultados modificados a partir de :date</p>",
    "permission": [
      {
        "name": "user",
        "title": "Cualquier Usuario",
        "description": "<p>Requiere User y Password validos definidos en Header</p>"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Clave Unica de Acceso RFC2045-MIME (Base64).</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Header:",
          "content": "{\"Authorization\":\"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3\"}",
          "type": "Json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Date",
            "optional": true,
            "field": "date",
            "description": "<p>Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong></p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "401",
            "description": "<p>Usuario o Contraseña Invalidos</p>"
          },
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "404",
            "description": "<p>LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Error 401:",
          "content": "{\"ERROR\":\"USARIO/CONTRASEÑA INVALIDOS\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...\"}",
          "type": "Json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Json",
            "optional": false,
            "field": "200",
            "description": "<p>Arreglo de Objetos de tipo MODULO</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Respuesta:",
          "content": "{\"MODULOS\":[{\"ID_MODULO\":\"1\",\"DESCRIPCION\":\"IDENTIFICACION Y UBICACI\\u00d3N\",\"CODIGO\":\"1\",\"ENTIDAD\":\"\",\"ESTADO\":\"A\",\"ORDEN\":\"1\",\"TIPO\":\"P\",\"VALIDAR\":\"N\",\"EDADINI\":\"\",\"EDADFIN\":\"\",\"GENERO\":\"A\",\"MODULO_P\":\" \",\"REGISTROS\":\"N\"},{\"ID_MODULO\":\"2\",\"DESCRIPCION\":\"PERSONAS DE LA FAMILIA\",\"CODIGO\":\"2\",\"ENTIDAD\":\"\",\"ESTADO\":\"A\",\"ORDEN\":\"2\",\"TIPO\":\"F\",\"VALIDAR\":\"N\",\"EDADINI\":\"\",\"EDADFIN\":\"\",\"GENERO\":\"A\",\"MODULO_P\":\"\",\"REGISTROS\":\"S\"},{...}]}",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "Modulos",
    "name": "GetModulosDate"
  },
  {
    "type": "GET",
    "url": "/Municipios/:date",
    "title": "",
    "group": "Municipios",
    "description": "<p>Retorna Todos los registros de Municipios, si se provee :date se filtraran los resultados modificados a partir de :date</p>",
    "permission": [
      {
        "name": "user",
        "title": "Cualquier Usuario",
        "description": "<p>Requiere User y Password validos definidos en Header</p>"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Clave Unica de Acceso RFC2045-MIME (Base64).</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Header:",
          "content": "{\"Authorization\":\"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3\"}",
          "type": "Json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Date",
            "optional": true,
            "field": "date",
            "description": "<p>Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong></p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "401",
            "description": "<p>Usuario o Contraseña Invalidos</p>"
          },
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "404",
            "description": "<p>LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Error 401:",
          "content": "{\"ERROR\":\"USARIO/CONTRASEÑA INVALIDOS\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...\"}",
          "type": "Json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Json",
            "optional": false,
            "field": "200",
            "description": "<p>Arreglo de Objetos de tipo MUNICIPIO</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Respuesta:",
          "content": "{\"MUNICIPIOS\":[{\"ID\":\"25\",\"NOMBRE\":\"AMAGÁ Antioquia\",\"ID_DPTO\":\"05\",\"NOMBRE_DPTO\":\"Antioquia\",\"CODIGO\":\"030\",\"ID_CIUDAD\":\"05030\",\"ESTADO\":\"0\"},{...}]}",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "Municipios",
    "name": "GetMunicipiosDate"
  },
  {
    "type": "GET",
    "url": "/Novedades/listas/:date",
    "title": "Listas",
    "group": "Novedades",
    "description": "<p>Retorna Todas las Listas de Novedades, si se provee :date se filtraran los resultados modificados a partir de :date</p>",
    "permission": [
      {
        "name": "user",
        "title": "Cualquier Usuario",
        "description": "<p>Requiere User y Password validos definidos en Header</p>"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Clave Unica de Acceso RFC2045-MIME (Base64).</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Header:",
          "content": "{\"Authorization\":\"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3\"}",
          "type": "Json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Date",
            "optional": true,
            "field": "date",
            "description": "<p>Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong></p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "401",
            "description": "<p>Usuario o Contraseña Invalidos</p>"
          },
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "404",
            "description": "<p>LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Error 401:",
          "content": "{\"ERROR\":\"USARIO/CONTRASEÑA INVALIDOS\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...\"}",
          "type": "Json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Json",
            "optional": false,
            "field": "200",
            "description": "<p>Arreglo de Objetos de tipo LISTA_NOVEDAD</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Respuesta:",
          "content": "{\"LISTAS_NOVEDAD\":[{\"COD_NOVEDAD\":\"1\",\"TIPO_NOVEDAD\":\"N01\",\"DESCRIPCION\":\"NUEVO TIPO DE DOCUMENTO DE IDENTIDAD\",\"ESTADO\":\"A\",\"VALOR\":\"1\"},{...}]}",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "Novedades",
    "name": "GetNovedadesListasDate"
  },
  {
    "type": "GET",
    "url": "/Novedades/tipos/:date",
    "title": "Tipos",
    "group": "Novedades",
    "description": "<p>Retorna Todos los registros de Tipos de Novedades, si se provee :date se filtraran los resultados modificados a partir de :date</p>",
    "permission": [
      {
        "name": "user",
        "title": "Cualquier Usuario",
        "description": "<p>Requiere User y Password validos definidos en Header</p>"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Clave Unica de Acceso RFC2045-MIME (Base64).</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Header:",
          "content": "{\"Authorization\":\"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3\"}",
          "type": "Json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Date",
            "optional": true,
            "field": "date",
            "description": "<p>Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong></p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "401",
            "description": "<p>Usuario o Contraseña Invalidos</p>"
          },
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "404",
            "description": "<p>LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Error 401:",
          "content": "{\"ERROR\":\"USARIO/CONTRASEÑA INVALIDOS\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...\"}",
          "type": "Json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Json",
            "optional": false,
            "field": "200",
            "description": "<p>Arreglo de Objetos de tipo TIPO_NOVEDAD</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Respuesta:",
          "content": "{\"TIPOS_NOVEDAD\":[{\"TIPO_NOVEDAD\":\"NA-03\",\"DESCRIPCION\":\"NO ATIENDE PORQUE YA FUE VISITADO EN OTRO NUCLEO FAMILIAR\",\"ESTADO\":\"A\"},{...}]}",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "Novedades",
    "name": "GetNovedadesTiposDate"
  },
  {
    "type": "GET",
    "url": "/PEC/GruposObjetivo",
    "title": "Grupos",
    "group": "PEC",
    "description": "<p>Retorna la lista de Grupos Objetivo de PEC Completa</p>",
    "permission": [
      {
        "name": "user",
        "title": "Cualquier Usuario",
        "description": "<p>Requiere User y Password validos definidos en Header</p>"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Clave Unica de Acceso RFC2045-MIME (Base64).</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Header:",
          "content": "{\"Authorization\":\"Basic eWVubnkubmF2YXJybzowZTljMzA1YmUyMDg2ZGRkZGU3NDM3MzUxMDVhY2ViNQ==\"}",
          "type": "Json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "401",
            "description": "<p>Usuario o Contraseña Invalidos</p>"
          },
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "404",
            "description": "<p>LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Error 401:",
          "content": "{\"ERROR\":\"USARIO/CONTRASEÑA INVALIDOS\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...\"}",
          "type": "Json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Json",
            "optional": false,
            "field": "200",
            "description": "<p>Arreglo de Objetos de tipo PEC_GRUPO_OBJETIVO</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Respuesta:",
          "content": "{\"PEC_GRUPOS_OBJETIVO\":[{\"ID_OBJETIVO\":\"0 \",\"NOMBRE_OBJETIVO\":\"COORDINADORES LIDERES\"},{...}]}",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "PEC",
    "name": "GetPecGruposobjetivo"
  },
  {
    "type": "GET",
    "url": "/PEC/Guias/:date",
    "title": "Guias",
    "group": "PEC",
    "description": "<p>Retorna Las Guias PEC, si se provee :date se filtraran los resultados modificados a partir de :date</p>",
    "permission": [
      {
        "name": "user",
        "title": "Cualquier Usuario",
        "description": "<p>Requiere User y Password validos definidos en Header</p>"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Clave Unica de Acceso RFC2045-MIME (Base64).</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Header:",
          "content": "{\"Authorization\":\"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3\"}",
          "type": "Json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Date",
            "optional": true,
            "field": "date",
            "description": "<p>Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong></p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "401",
            "description": "<p>Usuario o Contraseña Invalidos</p>"
          },
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "404",
            "description": "<p>LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Error 401:",
          "content": "{\"ERROR\":\"USARIO/CONTRASEÑA INVALIDOS\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...\"}",
          "type": "Json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Json",
            "optional": false,
            "field": "200",
            "description": "<p>Arreglo de Objetos de tipo PEC_GUIA</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Respuesta:",
          "content": "{\"PEC_GUIAS\":[{\"ID_GUIA\":\"1\",\"NOMBRE_GUIA\":\"GUIA 1 \",\"GRUPO_OBJETIVO\":\"1|3\",\"PROCESOS\":\"6|\"},{...}]}",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "PEC",
    "name": "GetPecGuiasDate"
  },
  {
    "type": "GET",
    "url": "/PEC/Procesos",
    "title": "Procesos",
    "group": "PEC",
    "description": "<p>Retorna los Procesos PEC</p>",
    "permission": [
      {
        "name": "user",
        "title": "Cualquier Usuario",
        "description": "<p>Requiere User y Password validos definidos en Header</p>"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Clave Unica de Acceso RFC2045-MIME (Base64).</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Header:",
          "content": "{\"Authorization\":\"Basic eWVubnkubmF2YXJybzowZTljMzA1YmUyMDg2ZGRkZGU3NDM3MzUxMDVhY2ViNQ==\"}",
          "type": "Json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "401",
            "description": "<p>Usuario o Contraseña Invalidos</p>"
          },
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "404",
            "description": "<p>LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Error 401:",
          "content": "{\"ERROR\":\"USARIO/CONTRASEÑA INVALIDOS\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...\"}",
          "type": "Json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Json",
            "optional": false,
            "field": "200",
            "description": "<p>Arreglo de Objetos de tipo PEC_PROCESO</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Respuesta:",
          "content": "{\"PEC_PROCESOS\":[{\"ID_PROCESO\":\"1\",\"NOMBRE_PROCESO\":\"ASEGURAMIENTO\"},{...}]}",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "PEC",
    "name": "GetPecProcesos"
  },
  {
    "type": "GET",
    "url": "/PEC/Programacion",
    "title": "Programacion",
    "group": "PEC",
    "description": "<p>Retorna la Programacion de Actividades PEC</p>",
    "permission": [
      {
        "name": "user",
        "title": "Cualquier Usuario",
        "description": "<p>Requiere User y Password validos definidos en Header</p>"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Clave Unica de Acceso RFC2045-MIME (Base64).</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Header:",
          "content": "{\"Authorization\":\"Basic eWVubnkubmF2YXJybzowZTljMzA1YmUyMDg2ZGRkZGU3NDM3MzUxMDVhY2ViNQ==\"}",
          "type": "Json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "401",
            "description": "<p>Usuario o Contraseña Invalidos</p>"
          },
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "404",
            "description": "<p>LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Error 401:",
          "content": "{\"ERROR\":\"USARIO/CONTRASEÑA INVALIDOS\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...\"}",
          "type": "Json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Json",
            "optional": false,
            "field": "200",
            "description": "<p>Arreglo de Objetos de tipo PEC_PROGRAMACION</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Respuesta:",
          "content": "{\"PEC_PROGRAMACIONES\":[{\"ID\":\"1\",\"GUIA\":\"2\",\"DEPARTAMENTO\":\"  \",\"CIUDAD\":\"     \",\"MIN_ASISTENTES\":\"20\",\"FECHA_INICIAL\":\"2014-07-01\",\"FECHA_FINAL\":\"2014-07-31\",\"GRUPO_OBJETO\":\"\",\"HORAS\":\"2\"},{...}]}",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "PEC",
    "name": "GetPecProgramacion"
  },
  {
    "type": "GET",
    "url": "/PEC/Temas/:date",
    "title": "Temas",
    "group": "PEC",
    "description": "<p>Retorna los Temas PEC, si se provee :date se filtraran los resultados modificados a partir de :date</p>",
    "permission": [
      {
        "name": "user",
        "title": "Cualquier Usuario",
        "description": "<p>Requiere User y Password validos definidos en Header</p>"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Clave Unica de Acceso RFC2045-MIME (Base64).</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Header:",
          "content": "{\"Authorization\":\"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3\"}",
          "type": "Json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Date",
            "optional": true,
            "field": "date",
            "description": "<p>Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong></p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "401",
            "description": "<p>Usuario o Contraseña Invalidos</p>"
          },
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "404",
            "description": "<p>LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Error 401:",
          "content": "{\"ERROR\":\"USARIO/CONTRASEÑA INVALIDOS\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...\"}",
          "type": "Json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Json",
            "optional": false,
            "field": "200",
            "description": "<p>Arreglo de Objetos de tipo PEC_TEMA</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Respuesta:",
          "content": "{\"PEC_TEMAS\":[{\"ID_GUIA\":\"1\",\"ID_TEMA\":\"1\",\"NOMBRE_TEMA\":\"Habilidades Comunicativas\",\"PROCESOS\":\"1|3\",\"SERV_GRUPAL\":\"28\",\"SERV_INDIVIDUAL\":\"\"},{...}]}",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "PEC",
    "name": "GetPecTemasDate"
  },
  {
    "type": "GET",
    "url": "/Personas/:date",
    "title": "",
    "group": "Personas",
    "description": "<p>Retorna las Personas Afiliadas asignadas al usuario que realiza la peticion, si se provee :date se filtraran los resultados modificados a partir de :date</p>",
    "permission": [
      {
        "name": "specific_user",
        "title": "Usuario Especifico",
        "description": "<p>Requiere User y Password validos definidos en Header. Tenga en cuenta que se entregaran unicamente los registros relacionados con el usuario que realiza la peticion</p>"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Clave Unica de Acceso RFC2045-MIME (Base64).</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Header:",
          "content": "{\"Authorization\":\"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3\"}",
          "type": "Json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Date",
            "optional": true,
            "field": "date",
            "description": "<p>Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong></p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "401",
            "description": "<p>Usuario o Contraseña Invalidos</p>"
          },
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "404",
            "description": "<p>LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Error 401:",
          "content": "{\"ERROR\":\"USARIO/CONTRASEÑA INVALIDOS\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...\"}",
          "type": "Json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Json",
            "optional": false,
            "field": "200",
            "description": "<p>Arreglo de Objetos de tipo PERSONA</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Respuesta:",
          "content": "{\"PERSONAS\":[{\"ID_USUARIO\":\"3\", \"APELLIDO1\":\"CONTRERAS\", \"APELLIDO2\":\"DE CONTRERAS\", \"NOMBRE1\":\"BARBARA\", \"NOMBRE2\":\"\", \"TIPODOC\":\"CC\", \"DOCUMENTO\":\"28133884\", \"CARNET\":\"68296297329\", \"FECHANAC\":\"1947-05-10\", \"SEXO\":\"F\", \"ESTADO\":\"AC\", \"DPTO\":\"68\", \"MUNICIPIO\":\"296\", \"SITUACION\":\"\", \"CODINST\":\"ESS024\", \"CELULAR\":\"\", \"EMAIL\":\"\", \"PESONACER\":\"\", \"TALLANACER\":\"\", \"DOCMAMA\":\"\", \"DOCPAPA\":\"\", \"PROMOTOR\":\"\", \"IDULTVISITA\":\"1459974\", \"FECULTVISITA\":\"2017-01-30\", \"PROGRAMADO\":\"\", \"PROGRAMACION\":\"\", \"USERCREA\":\"ADMIN\", \"FECCREA\":\"2015-10-20-05.27.40.865969\", \"IPCREA\":\"\", \"USERMODI\":\"amparo.cordero\", \"IPMODI\":\"190.242.76.52\", \"FECMODI\":\"2017-01-30-13.46.07.521480\"},{...}]}",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "Personas",
    "name": "GetPersonasDate"
  },
  {
    "type": "GET",
    "url": "/Preguntas/:date",
    "title": "",
    "group": "Preguntas",
    "description": "<p>Retorna el Listado de Preguntas, si se provee :date se filtraran los resultados modificados a partir de :date</p>",
    "permission": [
      {
        "name": "user",
        "title": "Cualquier Usuario",
        "description": "<p>Requiere User y Password validos definidos en Header</p>"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Clave Unica de Acceso RFC2045-MIME (Base64).</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Header:",
          "content": "{\"Authorization\":\"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3\"}",
          "type": "Json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Date",
            "optional": true,
            "field": "date",
            "description": "<p>Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong></p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "401",
            "description": "<p>Usuario o Contraseña Invalidos</p>"
          },
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "404",
            "description": "<p>LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Error 401:",
          "content": "{\"ERROR\":\"USARIO/CONTRASEÑA INVALIDOS\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...\"}",
          "type": "Json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Json",
            "optional": false,
            "field": "200",
            "description": "<p>Arreglo de Objetos de tipo PREGUNTA</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Respuesta:",
          "content": "{\"PREGUNTAS\":[{\"ID_PREGUNTA\":\"20788\",\"DESCRIPCION\":\"COD. DPTO\",\"ENTIDAD\":\"HC_MEDICA\",\"ATRIBUTO\":\"DPTO\",\"TIPOCAMPO\":\"\",\"LONCAMPO\":\"\",\"DEPENDE\":\"\",\"OBLIGATORIO\":\"\",\"ID_MODULO\":\"\",\"ID_LISTA\":\"\",\"NOMLISTA\":\"\",\"VALORLISTA\":\"\",\"CAMPOSIRFAM\":\"\",\"TIPO\":\"\",\"VALIDAR\":\"\",\"EDADINI\":\"\",\"EDADFIN\":\"\",\"GENERO\":\"\",\"ESTADO\":\"\",\"VISIBILIDAD\":\"\",\"NIVEL\":\"\",\"CODIGO\":\"\",\"ORDEN\":\"\",\"FECCREA\":\"\",\"FECMODI\":\"\"},{...}]}",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "Preguntas",
    "name": "GetPreguntasDate"
  },
  {
    "type": "GET",
    "url": "/Procedimientos",
    "title": "",
    "group": "Procedimientos",
    "description": "<p>Retorna el Listado de Procedimientos</p>",
    "permission": [
      {
        "name": "user",
        "title": "Cualquier Usuario",
        "description": "<p>Requiere User y Password validos definidos en Header</p>"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Clave Unica de Acceso RFC2045-MIME (Base64).</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Header:",
          "content": "{\"Authorization\":\"Basic eWVubnkubmF2YXJybzowZTljMzA1YmUyMDg2ZGRkZGU3NDM3MzUxMDVhY2ViNQ==\"}",
          "type": "Json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "401",
            "description": "<p>Usuario o Contraseña Invalidos</p>"
          },
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "404",
            "description": "<p>LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Error 401:",
          "content": "{\"ERROR\":\"USARIO/CONTRASEÑA INVALIDOS\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...\"}",
          "type": "Json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Json",
            "optional": false,
            "field": "200",
            "description": "<p>Arreglo de Objetos de tipo PROCEDIMIENTO</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Respuesta:",
          "content": "{\"PROCEDIMIENTOS\":[{\"ID_PROCEDIMIENTO\":\"3186\",\"CODIGO\":\"395307\",\"DESCRIPCION\":\"CIERRE DE FISTULA VENOVENOSA VIA ABIERTA\",\"ESTADO\":\"1\"},{...}]",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "Procedimientos",
    "name": "GetProcedimientos"
  },
  {
    "type": "GET",
    "url": "/Programaciones/:date",
    "title": "GET",
    "group": "Programaciones",
    "description": "<p>Retorna la Programacion asignada al usuario que realiza la peticion, si se provee :date se filtraran los resultados modificados a partir de :date</p>",
    "permission": [
      {
        "name": "specific_user",
        "title": "Usuario Especifico",
        "description": "<p>Requiere User y Password validos definidos en Header. Tenga en cuenta que se entregaran unicamente los registros relacionados con el usuario que realiza la peticion</p>"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Clave Unica de Acceso RFC2045-MIME (Base64).</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Header:",
          "content": "{\"Authorization\":\"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3\"}",
          "type": "Json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Date",
            "optional": true,
            "field": "date",
            "description": "<p>Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong></p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "401",
            "description": "<p>Usuario o Contraseña Invalidos</p>"
          },
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "404",
            "description": "<p>LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Error 401:",
          "content": "{\"ERROR\":\"USARIO/CONTRASEÑA INVALIDOS\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...\"}",
          "type": "Json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Json",
            "optional": false,
            "field": "200",
            "description": "<p>Arreglo de Objetos de tipo PROGRAMACION</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Respuesta:",
          "content": "{\"PROGRAMACIONES\":[{\"ID_PROGRAMACION\":\"11063\",\"DPTO\":\"08\",\"MUNICIPIO\":\"001\",\"PROMOTOR\":\"8389\",\"CEB\":\"1061\",\"ESTADO\":\"A\",\"ID_VISITA\":\"\",\"DIRECCION\":\"\",\"OTRADIR\":\"\",\"TELEFONO1\":\"\",\"TELEFONO2\":\"\",\"EMAIL\":\"\",\"LATITUD\":\"\",\"LONGITUD\":\"\",\"ID_BARRIO\":\"\",\"BARRIO\":\"\",\"FECPROG\":\"2017-01-31\",\"PERSONAS\":[{\"ID_USUARIO\":\"3\",\"MOTVISITA\":\"\",\"TIPOVISITA\":\"\",\"PARENTESCO\":\"\"}]},{...}]}",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "Programaciones",
    "name": "GetProgramacionesDate"
  },
  {
    "type": "post",
    "url": "/Programaciones/:date",
    "title": "POST",
    "name": "Programaciones",
    "group": "Programaciones",
    "description": "<p>Retorna la Programacion asignada al usuario que realiza la peticion, si se provee :date se filtraran los resultados modificados a partir de :date A diferencia del metodo GET, este recurso recibe un arreglo de ID_PROGRAMACION desde el cliente, realiza operaciones comparativas en el Servidor y devuelve los registros faltantes para mentener simetría entre Cliente y Servidor</p>",
    "permission": [
      {
        "name": "specific_user",
        "title": "Usuario Especifico",
        "description": "<p>Requiere User y Password validos definidos en Header. Tenga en cuenta que se entregaran unicamente los registros relacionados con el usuario que realiza la peticion</p>"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Clave Unica de Acceso RFC2045-MIME (Base64).</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Header:",
          "content": "{\"Authorization\":\"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3\"}",
          "type": "Json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Date",
            "optional": true,
            "field": "date",
            "description": "<p>Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong></p>"
          },
          {
            "group": "Parameter",
            "type": "Json",
            "optional": false,
            "field": "File",
            "description": "<p>Archivo json que contiene los ID_PROGRAMACION positivos que posee el Cliente</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "[\"10004\", \"10009\", \"10011\", \"11067\", \"11071\",\"1111\",\"10998\"]",
          "type": "Json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "401",
            "description": "<p>Usuario o Contraseña Invalidos</p>"
          },
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "404",
            "description": "<p>LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Error 401:",
          "content": "{\"ERROR\":\"USARIO/CONTRASEÑA INVALIDOS\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...\"}",
          "type": "Json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Json",
            "optional": false,
            "field": "200",
            "description": "<p>Arreglo de Objetos de tipo PROGRAMACION</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Respuesta:",
          "content": "{\"PROGRAMACIONES\":[{\"ID_PROGRAMACION\":\"11063\",\"DPTO\":\"08\",\"MUNICIPIO\":\"001\",\"PROMOTOR\":\"8389\",\"CEB\":\"1061\",\"ESTADO\":\"A\",\"ID_VISITA\":\"\",\"DIRECCION\":\"\",\"OTRADIR\":\"\",\"TELEFONO1\":\"\",\"TELEFONO2\":\"\",\"EMAIL\":\"\",\"LATITUD\":\"\",\"LONGITUD\":\"\",\"ID_BARRIO\":\"\",\"BARRIO\":\"\",\"FECPROG\":\"2017-01-31\",\"PERSONAS\":[{\"ID_USUARIO\":\"3\",\"MOTVISITA\":\"\",\"TIPOVISITA\":\"\",\"PARENTESCO\":\"\"}]},{...}]}",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "Programaciones"
  },
  {
    "type": "GET",
    "url": "/TiposUsuario",
    "title": "",
    "group": "TiposUsuario",
    "description": "<p>Retorna La Lista de Tipos de Usuarios Completa</p>",
    "permission": [
      {
        "name": "user",
        "title": "Cualquier Usuario",
        "description": "<p>Requiere User y Password validos definidos en Header</p>"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Clave Unica de Acceso RFC2045-MIME (Base64).</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Header:",
          "content": "{\"Authorization\":\"Basic eWVubnkubmF2YXJybzowZTljMzA1YmUyMDg2ZGRkZGU3NDM3MzUxMDVhY2ViNQ==\"}",
          "type": "Json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "401",
            "description": "<p>Usuario o Contraseña Invalidos</p>"
          },
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "404",
            "description": "<p>LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Error 401:",
          "content": "{\"ERROR\":\"USARIO/CONTRASEÑA INVALIDOS\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...\"}",
          "type": "Json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Json",
            "optional": false,
            "field": "200",
            "description": "<p>Arreglo de Objetos de tipo TIPO_USUARIO</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Respuesta:",
          "content": "{\"TIPOS_USUARIO\":[{\"ID\":\"1\",\"NOMBRE\":\"Administrador\",\"CODIGO\":\"1\",\"ESTADO\":\"0\",\"ABREVIATURA\":\"ADM\"},{...}]}",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "TiposUsuario",
    "name": "GetTiposusuario"
  },
  {
    "type": "GET",
    "url": "/Usuarios/:date",
    "title": "",
    "group": "Usuarios",
    "description": "<p>Retorna el Listado de Usuarios del Sistema, si se provee :date se filtraran los resultados modificados a partir de :date</p>",
    "permission": [
      {
        "name": "user",
        "title": "Cualquier Usuario",
        "description": "<p>Requiere User y Password validos definidos en Header</p>"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Clave Unica de Acceso RFC2045-MIME (Base64).</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Header:",
          "content": "{\"Authorization\":\"Basic cHJ1ZWJhOjM0MDVlMmY1ODYxOTNiMjQ0MDRkODlmMzZjNDdmYmU3\"}",
          "type": "Json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Date",
            "optional": true,
            "field": "date",
            "description": "<p>Fecha de Ultima Sincronizacion de Registros formato <strong>UNIX TIMESTAMP</strong> o <strong>yyyy-mm-dd</strong></p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "401",
            "description": "<p>Usuario o Contraseña Invalidos</p>"
          },
          {
            "group": "Error 4xx",
            "type": "Json",
            "optional": false,
            "field": "404",
            "description": "<p>LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Error 401:",
          "content": "{\"ERROR\":\"USARIO/CONTRASEÑA INVALIDOS\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"LO QUE BUSCAS DEFINITIVAMENTE NO ESTÁ AQUÍ...\"}",
          "type": "Json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Json",
            "optional": false,
            "field": "200",
            "description": "<p>Arreglo de Objetos de tipo PREGUNTA</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo Respuesta:",
          "content": "{\"USUARIOS\":[{\"ID\":\"1\",\"NOMBRE\":\"admin\",\"PASSWORD\":\"21232f297a57a5a743894a0e4a801fc3\",\"TIPO_USUARIO\":\"1\",\"ACTIVO\":\"0\",\"EMAIL\":\"rennimunoz@saludfamiliar.com.co\",\"DPTO\":\"08\",\"PAIS\":\"57\",\"CIUDAD\":\"758\",\"MOVIL\":\"3162413498\",\"TELEFONO\":\"3930527\",\"DIRECCION\":\"Calle 73a # 22 - 45 PISO 2\",\"DOC_IDENT\":\"73238372\",\"NOMBRES\":\"RENNI DE JESUS\",\"APELLIDOS\":\"MU\\u00d1OZ OROZCO\",\"CARGO\":\"ADMINISTRADOR\",\"TIPO_DOC\":\"1\",\"INFORMA_A\":\"1\",\"FECHA_CREA\":\"2012-10-30 11:54:09.000000\",\"USER_CREA\":\"admin\",\"IP_CREA\":\"127.0.0.1\",\"FECHA_MODI\":\"2015-10-17 09:47:06.000000\",\"USER_MODI\":\"admin\",\"IP_MODI\":\"181.192.158.23\",\"START_LATITUD\":\"\",\"START_LONGITUD\":\"\"},{...}]}",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "Usuarios",
    "name": "GetUsuariosDate"
  }
] });
