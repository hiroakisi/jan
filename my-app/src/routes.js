import { BrowserRouter, Routes, Route } from "react-router-dom";

import Top from "./components/Top";
import Upload from "./components/Upload";
import Result from "./components/Result";

export default function Router() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Top />} />
        <Route path="/upload" element={<Upload />} />
        <Route path="/result" element={<Result />} />
      </Routes>
    </BrowserRouter>
  );
}
