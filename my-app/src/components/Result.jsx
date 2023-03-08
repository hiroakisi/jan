import * as React from "react";
import Button from "@mui/material/Button";
import Header from "./header";

export default function Result() {
  return (
    <>
      <Header />
      <div>
        this is result
        <Button variant="contained">Hello World</Button>
      </div>
    </>
  );
}
