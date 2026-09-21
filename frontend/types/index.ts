export interface Category {
  id: number;
  name: string;
  slug?: string;
}

export interface Product {
  id: number;
  name: string;
  slug: string;
  price: number;
  image: string;
  description?: string;
  stock?: number;
  category: Category;
}