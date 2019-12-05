# KerryBodine WP Theme
> nodejs, gulp, sass, php, js, bower

## General Info

- This theme use gulp tasks to generate final output for CSS and JS.
- Source files are located in `assets/js` and `assets/styles` folders.
- JS dependencies are handle via bower and they are installed in `assets/components`

## Branches

- `master` Production code. Usually setup to deploy to Production server.
- `stage` As an integration branch to run final tests before deploying to production. Updates here get pushed to the staging server.
- `develop` Where active development takes place. Updates here will go to the develop server
- `feature/<task-name>` To work in a specific task.

## Local Setup

_Node.JS v10.13 is recommended_
```bash
# Install deps
$ npm install

# Install any JS deps via bower
$ npx bower install

# Start and watch for changes
$ npx gulp
```

## Development Workflow
1. Active development happens in the developer local computer and it's in the `feature/*` or `develop` branch
2. When the feature is ready, the developer create a **Pull Request (PR)** in Bitbucket so others developers could review before merging
3. The merge will trigger a deployment to the server related server.
