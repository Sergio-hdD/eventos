import { Application } from '@hotwired/stimulus';

// Arranca Stimulus
const app = Application.start();

// Carga automática de controllers (Symfony UX estándar)
import './controllers';