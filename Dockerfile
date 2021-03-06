FROM microsoft/dotnet:2.2-sdk-alpine AS build
WORKDIR /app
COPY . /app/
RUN apk --no-cache add git && \
    dotnet restore && \
    dotnet publish -c Release -o out -r linux-musl-x64

FROM microsoft/dotnet:2.2-runtime-deps-alpine
WORKDIR /app
COPY wwwroot /app/wwwroot/
COPY --from=build /app/out /app/
RUN chmod +x /app/blog
CMD ["/app/blog"]
