import React, { useState } from "react";
import Button from "@mui/material/Button";
import Header from "./header";
import { Stack } from "@mui/material";
export default function Upload() {
  const [profileImage, setProfileImage] = useState("");

  const onFileInputChange = (e) => {
    if (!e.target.files) return;

    const fileObject = e.target.files[0];
    // オブジェクトURLを生成し、useState()を更新
    setProfileImage(window.URL.createObjectURL(fileObject));
  };
  const clearImg = () => {
    setProfileImage("");
  };
  return (
    <>
      <Header />
      <label htmlFor={`upload-button`}>
        <input
          accept="image/*"
          id="contained-button-file"
          type="file"
          onChange={onFileInputChange}
          // style={{ display: "none" }}
        />
        {/* <Button variant="contained" component="span">
          写真アップロード
        </Button> */}
      </label>
      <Button
        variant="contained"
        color="success"
        onClick={() => {
          console.log("send");
        }}
      >
        合計金額抽出
      </Button>
      <Button
        variant="contained"
        onClick={() => {
          clearImg();
        }}
      >
        クリア
      </Button>
      <Stack
        direction="row"
        justifyContent="flex-start"
        alignItems="center"
        spacing={2}
      >
        {profileImage && (
          <img
            src={profileImage}
            alt={"upload"}
            className="h-32 w-32 rounded-full"
          />
        )}
      </Stack>
    </>
  );
}
