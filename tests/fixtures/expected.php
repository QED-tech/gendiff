<?php

return [
    <<<JSON
{
  - follow: false
    host: hexlet.io
  - proxy: 123.234.53.22
  - timeout: 50
  + timeout: 20
  + verbose: true
}
JSON
    ,
    <<<JSON
{
    common: {
      + follow: false
        setting1: Value 1
      - setting2: 200
      - setting3: true
      + setting3: null
      + setting4: blah blah
      + setting5: {
            key5: value5
        }
        setting6: {
            doge: {
              - wow:
              + wow: so much
            }
            key: value
          + ops: vops
        }
    }
    group1: {
      - baz: bas
      + baz: bars
        foo: bar
      - nest: {
            key: value
        }
      + nest: str
    }
  - group2: {
        abc: 12345
        deep: {
            id: 45
        }
    }
  + group3: {
        deep: {
            id: {
                number: 45
            }
        }
        fee: 100500
    }
}
JSON
    ,
    <<<TEXT
Property 'common.follow' was added with value: false
Property 'common.setting2' was removed
Property 'common.setting3' was updated. From true to null
Property 'common.setting4' was added with value: 'blah blah'
Property 'common.setting5' was added with value: [complex value]
Property 'common.setting6.doge.wow' was updated. From '' to 'so much'
Property 'common.setting6.ops' was added with value: 'vops'
Property 'group1.baz' was updated. From 'bas' to 'bars'
Property 'group1.nest' was updated. From [complex value] to 'str'
Property 'group2' was removed
Property 'group3' was added with value: [complex value]
TEXT
    ,
    <<<JSON
[
    {
        "key": "common",
        "description": "parent",
        "children": [
            {
                "key": "follow",
                "value": "false",
                "changed": true,
                "description": "added"
            },
            {
                "key": "setting1",
                "value": "Value 1",
                "changed": false,
                "description": "unchanged"
            },
            {
                "key": "setting2",
                "value": 200,
                "changed": true,
                "description": "deleted"
            },
            {
                "key": "setting3",
                "oldValue": "true",
                "newValue": "null",
                "changed": true,
                "description": "update"
            },
            {
                "key": "setting4",
                "value": "blah blah",
                "changed": true,
                "description": "added"
            },
            {
                "key": "setting5",
                "value": {
                    "key5": "value5"
                },
                "changed": true,
                "description": "added"
            },
            {
                "key": "setting6",
                "description": "parent",
                "children": [
                    {
                        "key": "doge",
                        "description": "parent",
                        "children": [
                            {
                                "key": "wow",
                                "oldValue": "",
                                "newValue": "so much",
                                "changed": true,
                                "description": "update"
                            }
                        ]
                    },
                    {
                        "key": "key",
                        "value": "value",
                        "changed": false,
                        "description": "unchanged"
                    },
                    {
                        "key": "ops",
                        "value": "vops",
                        "changed": true,
                        "description": "added"
                    }
                ]
            }
        ]
    },
    {
        "key": "group1",
        "description": "parent",
        "children": [
            {
                "key": "baz",
                "oldValue": "bas",
                "newValue": "bars",
                "changed": true,
                "description": "update"
            },
            {
                "key": "foo",
                "value": "bar",
                "changed": false,
                "description": "unchanged"
            },
            {
                "key": "nest",
                "oldValue": {
                    "key": "value"
                },
                "newValue": "str",
                "changed": true,
                "description": "update"
            }
        ]
    },
    {
        "key": "group2",
        "value": {
            "abc": 12345,
            "deep": {
                "id": 45
            }
        },
        "changed": true,
        "description": "deleted"
    },
    {
        "key": "group3",
        "value": {
            "deep": {
                "id": {
                    "number": 45
                }
            },
            "fee": 100500
        },
        "changed": true,
        "description": "added"
    }
]
JSON
];
