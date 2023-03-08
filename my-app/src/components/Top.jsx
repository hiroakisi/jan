import * as React from "react";
import Button from "@mui/material/Button";
import Header from "./header";

export default function Top() {
  return (
    <>
      <Header />
      <div>
        this is top
        <Button variant="contained">Hello World</Button>
      </div>
    </>
  );
}
