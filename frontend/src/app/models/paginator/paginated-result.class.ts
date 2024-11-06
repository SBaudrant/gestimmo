export class PaginatedResult<T> {
  items: T[];
  itemsCount: number;
  itemsPerPage: number;
  currentPage: number;

  constructor(items: T[], itemsCount: number, itemsPerPage: number, currentPage: number) {
    this.items = items;
    this.itemsCount = itemsCount;
    this.itemsPerPage = itemsPerPage;
    this.currentPage = currentPage;
  }

  getNextPage(): number | null {
    return this.currentPage + 1 <= this.getLastPage() ? this.currentPage + 1 : null;
  }

  getLastPage(): number {
    return Math.ceil(this.itemsCount / this.itemsPerPage);
  }
}
