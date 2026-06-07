import { Application } from '@hotwired/stimulus';

const application = Application.start();

// Auto-registra todos los controllers en esta carpeta
import { definitionsFromContext } from '@hotwired/stimulus-webpack-helpers';

const context = require.context('.', true, /_controller\.js$/);
application.load(definitionsFromContext(context));

export { application };