``` yaml
when@dev:
    web_profiler:
        intercept_redirects: true
        toolbar: true

    framework:
        profiler:
            collect_serializer_data: true

when@test:
    framework:
        profiler:
            collect: false
            collect_serializer_data: true

```
