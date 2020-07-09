
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta name="viewport" content="width=device-width" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title><?=$subject?></title>
</head>
  <body style="background-color: #222533; padding: 15px; font-family: font-size: 14px; line-height: 1.43; font-family: Helvetica Neue, Segoe UI, Helvetica, Arial, sans-serif;">
    <div style="max-width: 650px; margin: 0px auto; background-color: #fff; box-shadow: 0px 20px 50px rgba(0,0,0,0.05);">
      <table style="width: 100%;">
        <tr>
          <td style="background-color: #fff;">
            <h3 style="font-variant: small-caps;"> <?=env('project_name')??get_settings('project_name')?></h3>
          </td>
        </tr>
      </table>
      <div style="padding: 60px 70px; border-top: 1px solid rgba(0,0,0,0.05);">
        <div style="color: #636363; font-size: 14px;">
            <?=$this->renderSection("content")?>
        </div>
      </div>
    </div>
  </body>
</html>