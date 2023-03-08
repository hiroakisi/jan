import React, { useState } from "react";
import Button from "@mui/material/Button";
import Header from "./header";
import {
  Stack,
  InputLabel,
  MenuItem,
  FormControl,
  Select,
  TextField,
  InputAdornment,
} from "@mui/material";
import { styled } from "@mui/material/styles";

const Input = styled("input")({
  display: "none",
});
export default function Upload() {
  const [profileImage, setProfileImage] = useState("");
  const [price, setPrice] = useState(0);
  const [genre, setGenre] = React.useState(1);

  const handleGenreChange = (event) => {
    setGenre(event.target.value);
  };
  const handlePriceChange = (event) => {
    setPrice(event.target.value);
  };

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
      <Stack justifyContent="flex-start" spacing={2}>
        <Stack direction="row" spacing={2}>
          <label htmlFor="contained-button-file">
            <Input
              accept="image/*"
              id="contained-button-file"
              onChange={onFileInputChange}
              type="file"
            />
            <Button variant="contained" component="span">
              写真アップロード
            </Button>
          </label>
          <Button
            variant="contained"
            color="success"
            onClick={() => {
              setPrice(1000);
              console.log("send");
              console.log(profileImage);
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
        </Stack>
        <Stack direction="row" spacing={2}>
          <FormControl variant="standard" sx={{ mx: 2, minWidth: 100 }}>
            <InputLabel>ジャンル</InputLabel>
            <Select
              value={genre}
              label="ジャンル"
              InputLabelProps={{ shrink: true }}
              onChange={handleGenreChange}
            >
              <MenuItem value={1}>食費</MenuItem>
              <MenuItem value={2}>ゲーム</MenuItem>
              <MenuItem value={3}>ガソリン</MenuItem>
            </Select>
          </FormControl>
          <TextField
            required
            label="金額"
            variant="standard"
            value={price}
            onChange={handlePriceChange}
            InputProps={{
              endAdornment: (
                <InputAdornment position="start">円</InputAdornment>
              ),
            }}
            sx={{ width: 100 }}
          />
          <Button
            variant="contained"
            onClick={() => {
              console.log(genre);
              console.log("save");
            }}
          >
            保存
          </Button>
        </Stack>
      </Stack>

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
        {/* <img
          src={
            "blob:http://localhost:3000/ceeae2cf-61ee-4cd6-a020-9de63247020c"
          }
          alt={"upload"}
          className="h-32 w-32 rounded-full"
        /> */}
      </Stack>
    </>
  );
}
