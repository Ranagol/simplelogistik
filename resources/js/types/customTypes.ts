/**
 * Here are all the custome types that we need for TS.
 * Reminder: all model types are generated from the backend models, with the help of:
 * Model Typer.
 * 
 * sail artisan model:typer > resources/js/types/model_to_type.d.ts --optional-nullables --optional-relations --plurals --no-hidden
 * 
 * These model type are in the resources/js/types/model_to_type.d.ts
 * IMPORTANT: this file will be overwritten, so don't put anything here.
 */

import { TmsRequirement } from "./model_to_type";

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

}

export interface DataFromController {
    data: TmsRequirement[];
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

//Used in Requirements/Index and Table
export interface TableColumn {
    prop: string;
    label: string;
    sortable: string;
    width?: string;
}
