import Link from "next/link";
import { Product } from "@/types";
import { formatPrice } from "@/lib/format";

export default function ProductCard({ product }: { product: Product }) {
  return (
    <Link
      href={`/products/${product.id}`}
      className="block overflow-hidden rounded-lg border bg-white transition hover:shadow-md"
    >
      <div className="flex h-48 items-center justify-center bg-gray-200 text-gray-400">
        Ảnh sản phẩm
      </div>
      <div className="p-4">
        <p className="text-xs text-gray-500">{product.category.name}</p>
        <h3 className="mt-1 font-medium">{product.name}</h3>
        <p className="mt-2 font-semibold text-red-600">
          {formatPrice(product.price)}
        </p>
      </div>
    </Link>
  );
}