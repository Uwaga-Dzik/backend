---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost/uwagadzik/backend/docs/collection.json)

<!-- END_INFO -->

#general


<!-- START_0bef4e738c9d6720ad43b062015d1078 -->
## api/test

> Example request:

```bash
curl -X GET \
    -G "http://localhost/uwagadzik/backend/api/test" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/uwagadzik/backend/api/test"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "status": 200,
    "message": "wersja pierwsza CI CD"
}
```

### HTTP Request
`GET api/test`


<!-- END_0bef4e738c9d6720ad43b062015d1078 -->


