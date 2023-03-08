import React from "react";
import {
  AppBar,
  Box,
  Toolbar,
  Button,
  Typography,
  IconButton,
  Stack,
} from "@mui/material";
import { useNavigate } from "react-router-dom";
import SettingsIcon from "@mui/icons-material/Settings";
const Header = () => {
  const navigate = useNavigate();
  const navigateUpload = () => {
    navigate("/upload");
  };
  const navigateResult = () => {
    navigate("/result");
  };
  return (
    <Box sx={{ flexGrow: 1 }}>
      <AppBar position="static">
        <Toolbar>
          <Stack
            direction="row"
            justifyContent="space-between"
            alignItems="center"
            spacing={2}
            sx={{ width: "100%" }}
          >
            <Stack
              direction="row"
              justifyContent="flex-start"
              alignItems="center"
              spacing={2}
            >
              <Typography>家計簿管理システム（仮）</Typography>
              <Button
                variant="contained"
                color="secondary"
                onClick={() => navigateUpload()}
                sx={{ mx: 2 }}
              >
                写真取り込み
              </Button>
              <Button
                variant="contained"
                color="secondary"
                onClick={() => navigateResult()}
              >
                保存済確認
              </Button>
            </Stack>
            <Stack>
              <IconButton
                size="small"
                onClick={() => {
                  console.log("setting");
                }}
              >
                <SettingsIcon />
              </IconButton>
            </Stack>
          </Stack>
        </Toolbar>
      </AppBar>
    </Box>
  );
};

export default Header;
