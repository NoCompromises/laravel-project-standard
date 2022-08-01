FROM node:16.16.0-alpine3.16

# starting with node 16 the default work directory changed to someplace with existing files, we set it to a clean folder
WORKDIR /usr/app

# after installing a specific npm version, we move it into the correct location and clean up the remaining source files
RUN npm install npm@8.15.0 \
    && rm -rf /usr/local/lib/node_modules/npm \
    && mv /usr/app/node_modules/npm /usr/local/lib/node_modules/npm \
    && rm -rf /usr/app/node_modules \
    && rm /usr/app/package.json /usr/app/package-lock.json
