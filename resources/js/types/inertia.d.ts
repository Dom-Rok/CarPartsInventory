import { Page } from '@inertiajs/vue3'

export interface FlashProps {
  success?: string | null;
  error?: string | null;
}

export interface PageProps {
  flash: FlashProps;
  
  [key: string]: any; 
}
