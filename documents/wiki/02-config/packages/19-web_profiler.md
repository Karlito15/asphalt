when@dev:
    web_profiler:
        intercept_redirects: false
        toolbar: true

    framework:
        profiler:
            collect_serializer_data: true
            only_exceptions: false

when@test:
    web_profiler:
        toolbar: false
        intercept_redirects: false

    framework:
        profiler: { collect: false }
