import Link from "next/link";
import { Playfair_Display } from "next/font/google";

const logoFont = Playfair_Display({
  subsets: ["latin", "vietnamese"],
  weight: ["600", "700"],
});

export default function Header() {
  return (
    <header className="border-b bg-white/80 backdrop-blur">
      <div className="mx-auto flex max-w-6xl items-center justify-between px-4 py-4">
        <Link
          href="/"
          className={`${logoFont.className} bg-linear-to-r from-purple-900 to-pink-500 bg-clip-text text-2xl font-bold tracking-[0.2em] text-transparent`}
        >
          VENUS STORE
        </Link>
        <nav className="flex gap-6 text-sm font-semibold">
          <Link href="/" className="hover:text-blue-600">Trang chủ</Link>
          <Link href="/products" className="hover:text-blue-600">Sản phẩm</Link>
          <Link href="/cart" className="hover:text-blue-600">Giỏ hàng</Link>
          <Link href="/login" className="hover:text-blue-600">Đăng nhập</Link>
        </nav>
      </div>
    </header>
  );
}