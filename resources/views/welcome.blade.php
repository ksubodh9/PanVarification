<!DOCTYPE html>
<html>
<head>
  <title>PAN Verification</title>
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .container {
      text-align: center;
    }

    input[type="text"] {
      padding: 10px;
      width: 200px;
    }

    button {
      padding: 10px 20px;
      background-color: #007bff;
      color: white;
      border: none;
      cursor: pointer;
    }
    .data{
        text-align:inline;
    }
  </style>
</head>
<body>
  <div class="container">
    <form method="post" action="/verify-pan">
        @csrf
        <!-- <label for="">PAN Number</label> -->
      <input type="text" name="pan_number" placeholder="Enter pan number">
      <br><br>
      <button type="submit">Get Details</button>
    </form>
    <div class="data">
    @if(session('data') && isset(session('data')['data']))
    <h2>Verified: Your Pancard Details ✅</h2>
    <table>
        <tr>
            <th>Field</th>
            <th>Value</th>
        </tr>
        @foreach(session('data')['data'] as $field => $value)
            <tr>
                <td style="text-align:start">{{ $field }}</td>
                <td > @if(is_array($value))
                        @if(isset($value['full']))
                            {{ $value['full'] }}
                        @else
                            {{ implode(', ', array_filter($value)) }}
                        @endif
                    @else
                        {{ $value }}
                    @endif</td>
            </tr>
        @endforeach
    </table>
    @elseif(session('data') && isset(session('data')['status']) && session('data')['status'] === false)
    <p style="color: red; font-size: 18px;">{{ session('data')['message'] }}</p>
    @else
        
    @endif
    </div>
  </div>
</body>
</html>
