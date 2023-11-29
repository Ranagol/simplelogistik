/**
 * Here are all the custome types that we need for TS.
 * Reminder: all model types are generated from the backend models, with the help of:
 * Model Typer.
 * 
 * sail artisan model:typer > resources/js/types/model_to_type.d.ts --optional-nullables --optional-relations --plurals --no-hidden
 * 
 * These model type are in the resources/js/types/model_to_type.d.ts
 * IMPORTANT: this file(model_to_type.d.ts) will be overwritten regularly and every time when the
 * command above is run. This is the reason why we need this file here: these types will not be overwritten.
 */

import { TmsCustomers } from "./model_to_type";

export interface PaginationData {
    current_page: number;
    first_page_url: string;
    from: number;
    last_page: number;
    last_page_url: string;
    links: any[]; // Replace 'any' with the actual type of the items in the array if known
    next_page_url: string | null;
    path: string;
    per_page: number;
    prev_page_url: string | null;
    to: number;
    total: number;

};

export interface DataFromController {
    data: TmsCustomers;
    current_page: number;
    first_page_url: string;
    from: number;
    last_page: number;
    last_page_url: string;
    links: any[]; // Replace 'any' with the actual type of the items in the array if known
    next_page_url: string | null;
    path: string;
    per_page: number;
    prev_page_url: string | null;
    to: number;
    total: number;
};

export interface CustomerErrors {
    company_name: string | null,
    name: string | null,
    email: string | null,
    rating: string | null,
    tax_number: string | null,
    internal_cid: string | null,
}

