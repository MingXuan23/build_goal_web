# Use the official Node.js image from Docker Hub
FROM node:23-alpine

ENV PNPM_HOME="/pnpm"
ENV PATH="$PNPM_HOME:$PATH"
# Set the working directory inside the container

RUN apk update && apk add --no-cache tzdata

# Set the time zone to Asia/Kuala_Lumpur
ENV TZ=Asia/Kuala_Lumpur

WORKDIR /usr/src/app

# Install pnpm globally
RUN npm install -g pnpm

# Install nodemon globally
RUN pnpm add -g nodemon knex  http-errors

# RUN pnpm add http-errors

# Copy package.json and pnpm-lock.yaml (if available)
COPY package*.json ./

# Install dependencies using pnpm
RUN pnpm install

# Copy the rest of the application code
COPY . .

# Expose the port your app runs on (default is 3000 for Express)
EXPOSE 3000

# Command to run your application
CMD ["npm", "run", "start"]
