import { Product } from "@/types";

export const mockProducts: Product[] = [
  {
    id: 1,
    name: "Áo thun trắng",
    slug: "ao-thun-trang",
    price: 150000,
    image: "",
    description: "Chất liệu cotton, thoáng mát, dễ phối đồ.",
    stock: 25,
    category: { id: 1, name: "Áo" },
  },
  {
    id: 2,
    name: "Áo sơ mi xanh",
    slug: "ao-so-mi-xanh",
    price: 280000,
    image: "",
    description: "Sơ mi công sở, form vừa vặn.",
    stock: 12,
    category: { id: 1, name: "Áo" },
  },
  {
    id: 3,
    name: "Quần jean đen",
    slug: "quan-jean-den",
    price: 350000,
    image: "",
    description: "Jean co giãn nhẹ, bền màu.",
    stock: 30,
    category: { id: 2, name: "Quần" },
  },
  {
    id: 4,
    name: "Quần short kaki",
    slug: "quan-short-kaki",
    price: 200000,
    image: "",
    description: "Kaki mềm, phù hợp mặc hằng ngày.",
    stock: 18,
    category: { id: 2, name: "Quần" },
  },
];