import { Template } from "./template";

export interface TemplatesPagination {
    current_page: number;
    data: Template[];
    first_page_url: string,
    from: number,
    last_page: number,
    last_page_url: string,
    links: [],
    next_page_url: string,
    path: string,
    per_page: number,
    prev_page_url: string,
    to: number,
    total: number
}
