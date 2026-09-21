import Link from "next/link";
import ProductCard from "@/components/ProductCard";
import { mockProducts } from "@/lib/mock-data";

export default function HomePage() {
  return (
    <div>
      <section className="relative overflow-hidden rounded-lg">
  <img
    src="/banner.svg"
    alt="Venus Store - Tự do thể hiện, tự do tận hưởng"
    className="w-full"
  />
  <Link
  href="/products"
  className="absolute bottom-[6%] left-[8.5%] rounded bg-white px-3 py-1 text-xs font-semibold text-purple-900 hover:bg-pink-100 md:px-5 md:py-1.5 md:text-sm"
>
  Xem sản phẩm
</Link>
</section>

      <h2 className="mb-4 mt-10 text-xl font-semibold">Sản phẩm nổi bật</h2>
      <div className="grid grid-cols-2 gap-4 md:grid-cols-4">
        {mockProducts.map((p) => (
          <ProductCard key={p.id} product={p} />
        ))}
      </div>
    </div>
  );
}