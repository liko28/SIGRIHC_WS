define({ "api": [
  {
    "type": "GET",
    "url": "/Areas",
    "title": "all",
    "group": "Areas",
    "description": "<p>Retorna La Lista de Areas Completa</p>",
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
            "description": "<p>Ruta Invalida o Elemento No Encontrado</p>"
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
          "content": "{\"ERROR\":\"ELEMENTO NO ENCONTRADO\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"RUTA INVALIDA\"}",
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
          "content": "TODO EJEMPLO PENDIENTE",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "Areas",
    "name": "GetAreas"
  },
  {
    "type": "GET",
    "url": "/Areas/:date",
    "title": "updates",
    "group": "Areas",
    "description": "<p>Retorna Los registros de Areas que han sufrido modificaciones posteriores a :date</p>",
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
            "optional": false,
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
            "description": "<p>Ruta Invalida o Elemento No Encontrado</p>"
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
          "content": "{\"ERROR\":\"ELEMENTO NO ENCONTRADO\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"RUTA INVALIDA\"}",
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
          "content": "TODO EJEMPLO PENDIENTE",
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
    "title": "all",
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
            "description": "<p>Ruta Invalida o Elemento No Encontrado</p>"
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
          "content": "{\"ERROR\":\"ELEMENTO NO ENCONTRADO\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"RUTA INVALIDA\"}",
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
          "content": "TODO EJEMPLO PENDIENTE",
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
    "url": "/Departamentos",
    "title": "all",
    "group": "Departamentos",
    "description": "<p>Retorna La Lista de Departamentos Completa</p>",
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
            "description": "<p>Ruta Invalida o Elemento No Encontrado</p>"
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
          "content": "{\"ERROR\":\"ELEMENTO NO ENCONTRADO\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"RUTA INVALIDA\"}",
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
          "content": "{\"DEPARTAMENTO\":[{\"ID\" : \"2\",\"NOMBRE\" : \"ANTIOQUIA\",\"PAIS\" : \"57\",\"CODIGO\" : \"05\",\"ACTIVO\" : \"0\"}]}",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "Departamentos",
    "name": "GetDepartamentos"
  },
  {
    "type": "GET",
    "url": "/Departamentos/:date",
    "title": "updates",
    "group": "Departamentos",
    "description": "<p>Retorna Los registros de Departamentos que han sufrido modificaciones posteriores a :date</p>",
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
            "optional": false,
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
            "description": "<p>Ruta Invalida o Elemento No Encontrado</p>"
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
          "content": "{\"ERROR\":\"ELEMENTO NO ENCONTRADO\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"RUTA INVALIDA\"}",
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
          "content": "{\"DEPARTAMENTO\":[{\"ID\" : \"2\",\"NOMBRE\" : \"ANTIOQUIA\",\"PAIS\" : \"57\",\"CODIGO\" : \"05\",\"ACTIVO\" : \"0\"}]}",
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
    "type": "GET",
    "url": "/Ips",
    "title": "all",
    "group": "Ips",
    "description": "<p>Retorna la lista de Instituciones Prestadoras de Servicios Completa</p>",
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
            "description": "<p>Ruta Invalida o Elemento No Encontrado</p>"
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
          "content": "{\"ERROR\":\"ELEMENTO NO ENCONTRADO\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"RUTA INVALIDA\"}",
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
          "content": "TODO EJEMPLO PENDIENTE",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "Ips",
    "name": "GetIps"
  },
  {
    "type": "GET",
    "url": "/Ips/:date",
    "title": "updates",
    "group": "Ips",
    "description": "<p>Retorna Los registros de Instituciones Prestadoras de Servicios que han sufrido modificaciones posteriores a :date</p>",
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
            "optional": false,
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
            "description": "<p>Ruta Invalida o Elemento No Encontrado</p>"
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
          "content": "{\"ERROR\":\"ELEMENTO NO ENCONTRADO\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"RUTA INVALIDA\"}",
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
          "content": "TODO EJEMPLO PENDIENTE",
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
    "title": "all",
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
            "description": "<p>Ruta Invalida o Elemento No Encontrado</p>"
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
          "content": "{\"ERROR\":\"ELEMENTO NO ENCONTRADO\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"RUTA INVALIDA\"}",
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
          "content": "TODO EJEMPLO PENDIENTE",
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
    "url": "/ListasReferencia",
    "title": "all",
    "group": "ListasReferencia",
    "description": "<p>Retorna La Lista de Referencia Completa</p>",
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
            "description": "<p>Ruta Invalida o Elemento No Encontrado</p>"
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
          "content": "{\"ERROR\":\"ELEMENTO NO ENCONTRADO\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"RUTA INVALIDA\"}",
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
          "content": "{\"LISTA_REFERENCIA\":[{\"ID_LISTA\":\"1\",\"PADRE\":\"\",\"DESCRIPCION\":\"Motivo Visita\",\"CODLISTA\":\"\",\"VALOR\":\"\",\"ESTADO\":\"\"}]}",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "ListasReferencia",
    "name": "GetListasreferencia"
  },
  {
    "type": "GET",
    "url": "/ListasReferencia/:date",
    "title": "updates",
    "group": "ListasReferencia",
    "description": "<p>Retorna Los registros de Lista de Referencia que han sufrido modificaciones posteriores a :date</p>",
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
            "optional": false,
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
            "description": "<p>Ruta Invalida o Elemento No Encontrado</p>"
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
          "content": "{\"ERROR\":\"ELEMENTO NO ENCONTRADO\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"RUTA INVALIDA\"}",
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
          "content": "{\"LISTA_REFERENCIA\":[{\"ID_LISTA\":\"1\",\"PADRE\":\"\",\"DESCRIPCION\":\"Motivo Visita\",\"CODLISTA\":\"\",\"VALOR\":\"\",\"ESTADO\":\"\"}]}",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "ListasReferencia",
    "name": "GetListasreferenciaDate"
  },
  {
    "type": "GET",
    "url": "/Medicamentos",
    "title": "all",
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
            "description": "<p>Ruta Invalida o Elemento No Encontrado</p>"
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
          "content": "{\"ERROR\":\"ELEMENTO NO ENCONTRADO\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"RUTA INVALIDA\"}",
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
          "content": "TODO EJEMPLO PENDIENTE",
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
    "url": "/Modulos",
    "title": "all",
    "group": "Modulos",
    "description": "<p>Retorna el Listado de Modulos</p>",
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
            "description": "<p>Ruta Invalida o Elemento No Encontrado</p>"
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
          "content": "{\"ERROR\":\"ELEMENTO NO ENCONTRADO\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"RUTA INVALIDA\"}",
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
          "content": "TODO EJEMPLO PENDIENTE",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "Modulos",
    "name": "GetModulos"
  },
  {
    "type": "GET",
    "url": "/Modulos/:date",
    "title": "updates",
    "group": "Modulos",
    "description": "<p>Retorna el Listado de Modulos con modificaciones posteriores a :date</p>",
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
            "optional": false,
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
            "description": "<p>Ruta Invalida o Elemento No Encontrado</p>"
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
          "content": "{\"ERROR\":\"ELEMENTO NO ENCONTRADO\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"RUTA INVALIDA\"}",
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
          "content": "TODO EJEMPLO PENDIENTE",
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
    "url": "/Municipios",
    "title": "all",
    "group": "Municipios",
    "description": "<p>Retorna La Lista de Municipios Completa</p>",
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
            "description": "<p>Ruta Invalida o Elemento No Encontrado</p>"
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
          "content": "{\"ERROR\":\"ELEMENTO NO ENCONTRADO\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"RUTA INVALIDA\"}",
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
          "content": "{\"MUNICIPIO\":[{\"ID\":\"25\",\"NOMBRE\":\"AMAGÁ Antioquia\",\"ID_DPTO\":\"05\",\"NOMBRE_DPTO\":\"Antioquia\",\"CODIGO\":\"030\",\"ID_CIUDAD\":\"05030\",\"ESTADO\":\"0\"}]}",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "Municipios",
    "name": "GetMunicipios"
  },
  {
    "type": "GET",
    "url": "/Municipios/:date",
    "title": "updates",
    "group": "Municipios",
    "description": "<p>Retorna Los registros de Municipios que han sufrido modificaciones posteriores a :date</p>",
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
            "optional": false,
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
            "description": "<p>Ruta Invalida o Elemento No Encontrado</p>"
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
          "content": "{\"ERROR\":\"ELEMENTO NO ENCONTRADO\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"RUTA INVALIDA\"}",
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
          "content": "{\"MUNICIPIO\":[{\"ID\":\"25\",\"NOMBRE\":\"AMAGÁ Antioquia\",\"ID_DPTO\":\"05\",\"NOMBRE_DPTO\":\"Antioquia\",\"CODIGO\":\"030\",\"ID_CIUDAD\":\"05030\",\"ESTADO\":\"0\"}]}",
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
    "url": "/Novedades/campo",
    "title": "all",
    "group": "Novedades_Campos",
    "description": "<p>Retorna las Listas de Novedades</p>",
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
            "description": "<p>Ruta Invalida o Elemento No Encontrado</p>"
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
          "content": "{\"ERROR\":\"ELEMENTO NO ENCONTRADO\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"RUTA INVALIDA\"}",
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
          "content": "TODO EJEMPLO PENDIENTE",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "Novedades_Campos",
    "name": "GetNovedadesCampo"
  },
  {
    "type": "GET",
    "url": "/Novedades/lista/:date",
    "title": "updates",
    "group": "Novedades_Lista",
    "description": "<p>Retorna Las Listas de Novedades que han sufrido modificaciones posteriores a :date</p>",
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
            "optional": false,
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
            "description": "<p>Ruta Invalida o Elemento No Encontrado</p>"
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
          "content": "{\"ERROR\":\"ELEMENTO NO ENCONTRADO\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"RUTA INVALIDA\"}",
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
          "content": "TODO EJEMPLO PENDIENTE",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "Novedades_Lista",
    "name": "GetNovedadesListaDate"
  },
  {
    "type": "GET",
    "url": "/Novedades/tipo",
    "title": "all",
    "group": "Novedades_Tipo",
    "description": "<p>Retorna la lista de Tipos de Novedades Completa</p>",
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
            "description": "<p>Ruta Invalida o Elemento No Encontrado</p>"
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
          "content": "{\"ERROR\":\"ELEMENTO NO ENCONTRADO\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"RUTA INVALIDA\"}",
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
          "content": "TODO EJEMPLO PENDIENTE",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "Novedades_Tipo",
    "name": "GetNovedadesTipo"
  },
  {
    "type": "GET",
    "url": "/Novedades/tipo/:date",
    "title": "updates",
    "group": "Novedades_Tipos",
    "description": "<p>Retorna Los registros de Tipos de Novedades que han sufrido modificaciones posteriores a :date</p>",
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
            "optional": false,
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
            "description": "<p>Ruta Invalida o Elemento No Encontrado</p>"
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
          "content": "{\"ERROR\":\"ELEMENTO NO ENCONTRADO\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"RUTA INVALIDA\"}",
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
          "content": "TODO EJEMPLO PENDIENTE",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "Novedades_Tipos",
    "name": "GetNovedadesTipoDate"
  },
  {
    "type": "GET",
    "url": "/PEC/GruposObjetivo",
    "title": "all",
    "group": "PEC_Grupos_Objetivo",
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
            "description": "<p>Ruta Invalida o Elemento No Encontrado</p>"
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
          "content": "{\"ERROR\":\"ELEMENTO NO ENCONTRADO\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"RUTA INVALIDA\"}",
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
          "content": "TODO EJEMPLO PENDIENTE",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "PEC_Grupos_Objetivo",
    "name": "GetPecGruposobjetivo"
  },
  {
    "type": "GET",
    "url": "/PEC/Guias",
    "title": "all",
    "group": "PEC_Guias",
    "description": "<p>Retorna la lista de Guias PEC</p>",
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
            "description": "<p>Ruta Invalida o Elemento No Encontrado</p>"
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
          "content": "{\"ERROR\":\"ELEMENTO NO ENCONTRADO\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"RUTA INVALIDA\"}",
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
          "content": "TODO EJEMPLO PENDIENTE",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "PEC_Guias",
    "name": "GetPecGuias"
  },
  {
    "type": "GET",
    "url": "/PEC/Guias/:date",
    "title": "updates",
    "group": "PEC_Guias",
    "description": "<p>Retorna Las Guias PEC que han sufrido modificaciones posteriores a :date</p>",
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
            "optional": false,
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
            "description": "<p>Ruta Invalida o Elemento No Encontrado</p>"
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
          "content": "{\"ERROR\":\"ELEMENTO NO ENCONTRADO\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"RUTA INVALIDA\"}",
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
          "content": "TODO EJEMPLO PENDIENTE",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "PEC_Guias",
    "name": "GetPecGuiasDate"
  },
  {
    "type": "GET",
    "url": "/PEC/Procesos",
    "title": "all",
    "group": "PEC_Procesos",
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
            "description": "<p>Ruta Invalida o Elemento No Encontrado</p>"
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
          "content": "{\"ERROR\":\"ELEMENTO NO ENCONTRADO\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"RUTA INVALIDA\"}",
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
          "content": "TODO EJEMPLO PENDIENTE",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "PEC_Procesos",
    "name": "GetPecProcesos"
  },
  {
    "type": "GET",
    "url": "/PEC/Programacion",
    "title": "all",
    "group": "PEC_Programacion",
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
            "description": "<p>Ruta Invalida o Elemento No Encontrado</p>"
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
          "content": "{\"ERROR\":\"ELEMENTO NO ENCONTRADO\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"RUTA INVALIDA\"}",
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
          "content": "TODO EJEMPLO PENDIENTE",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "PEC_Programacion",
    "name": "GetPecProgramacion"
  },
  {
    "type": "GET",
    "url": "/PEC/temas",
    "title": "all",
    "group": "PEC_Temas",
    "description": "<p>Retorna la lista de Temas PEC</p>",
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
            "description": "<p>Ruta Invalida o Elemento No Encontrado</p>"
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
          "content": "{\"ERROR\":\"ELEMENTO NO ENCONTRADO\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"RUTA INVALIDA\"}",
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
          "content": "TODO EJEMPLO PENDIENTE",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "PEC_Temas",
    "name": "GetPecTemas"
  },
  {
    "type": "GET",
    "url": "/PEC/Temas/:date",
    "title": "updates",
    "group": "PEC_Temas",
    "description": "<p>Retorna los Temas PEC que han sufrido modificaciones posteriores a :date</p>",
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
            "optional": false,
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
            "description": "<p>Ruta Invalida o Elemento No Encontrado</p>"
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
          "content": "{\"ERROR\":\"ELEMENTO NO ENCONTRADO\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"RUTA INVALIDA\"}",
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
          "content": "TODO EJEMPLO PENDIENTE",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "PEC_Temas",
    "name": "GetPecTemasDate"
  },
  {
    "type": "GET",
    "url": "/Preguntas",
    "title": "all",
    "group": "Preguntas",
    "description": "<p>Retorna el Listado de Preguntas</p>",
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
            "description": "<p>Ruta Invalida o Elemento No Encontrado</p>"
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
          "content": "{\"ERROR\":\"ELEMENTO NO ENCONTRADO\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"RUTA INVALIDA\"}",
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
          "content": "TODO EJEMPLO PENDIENTE",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "Preguntas",
    "name": "GetPreguntas"
  },
  {
    "type": "GET",
    "url": "/Preguntas/:date",
    "title": "updates",
    "group": "Preguntas",
    "description": "<p>Retorna el Listado de Preguntas con modificaciones posteriores a :date</p>",
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
            "optional": false,
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
            "description": "<p>Ruta Invalida o Elemento No Encontrado</p>"
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
          "content": "{\"ERROR\":\"ELEMENTO NO ENCONTRADO\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"RUTA INVALIDA\"}",
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
          "content": "TODO EJEMPLO PENDIENTE",
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
    "url": "/Programaciones",
    "title": "all",
    "group": "Programaciones",
    "description": "<p>Retorna la Programacion asignada al usuario que realiza la peticion</p>",
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
            "description": "<p>Ruta Invalida o Elemento No Encontrado</p>"
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
          "content": "{\"ERROR\":\"ELEMENTO NO ENCONTRADO\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"RUTA INVALIDA\"}",
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
          "content": "TODO EJEMPLO PENDIENTE",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "Programaciones",
    "name": "GetProgramaciones"
  },
  {
    "type": "GET",
    "url": "/Programaciones/:date",
    "title": "updates",
    "group": "Programaciones",
    "description": "<p>Retorna la Programacion asignada al usuario que realiza la peticion y que haya sido modificado posterior a :date</p>",
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
            "optional": false,
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
            "description": "<p>Ruta Invalida o Elemento No Encontrado</p>"
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
          "content": "{\"ERROR\":\"ELEMENTO NO ENCONTRADO\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"RUTA INVALIDA\"}",
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
          "content": "TODO EJEMPLO PENDIENTE",
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
    "type": "GET",
    "url": "/TiposUsuario",
    "title": "all",
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
            "description": "<p>Ruta Invalida o Elemento No Encontrado</p>"
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
          "content": "{\"ERROR\":\"ELEMENTO NO ENCONTRADO\"}",
          "type": "Json"
        },
        {
          "title": "Ejemplo Error 404:",
          "content": "{\"ERROR\":\"RUTA INVALIDA\"}",
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
          "content": "TODO EJEMPLO PENDIENTE",
          "type": "Json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./index.php",
    "groupTitle": "TiposUsuario",
    "name": "GetTiposusuario"
  }
] });