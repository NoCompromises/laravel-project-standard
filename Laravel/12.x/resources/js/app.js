/** if going to use livewire and configure some alpine plugins, do it like this **/

import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import Autosize from '@marcreichel/alpine-autosize'; /** example **/

Alpine.plugin(Autosize);

Alpine.magic('autofocus', () => () => {
  Alpine.nextTick(() => document.querySelector('[autofocus]').focus());
});

Livewire.start();

/** Import images so you can access them with Vite::asset() **/
import.meta.glob([
  '../images/**',
]);
