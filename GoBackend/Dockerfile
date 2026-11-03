

# Stage 1: Build Go API
FROM golang:1.27.3-alpine3.24 AS builder

WORKDIR /app

COPY go.mod ./
RUN go mod download

COPY . .

RUN CGO_ENABLED=0 GOOS=linux go build -o task-api .


# Stage 2: Lightweight runtime
FROM alpine:3.24

RUN apk add --no-cache ca-certificates wget \
    && adduser -D -H appuser

WORKDIR /app

COPY --from=builder /app/task-api .

USER appuser

EXPOSE 8081

HEALTHCHECK --interval=30s --timeout=5s --start-period=5s --retries=3 \
    CMD wget -q -O /dev/null http://127.0.0.1:8081/health || exit 1

CMD ["./task-api"]
