import ProductCard from "@/components/ProductCard";
import { mockProducts } from "@/lib/mock-data";

export default function ProductsPage() {
  return (
    <div>
      <h1 className="mb-6 text-2xl font-bold">Tất cả sản phẩm</h1>
      <div className="grid grid-cols-2 gap-4 md:grid-cols-4">
        {mockProducts.map((p) => (
          <ProductCard key={p.id} product={p} />
        ))}
      </div>
    </div>
  );
}